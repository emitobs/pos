<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;
use App\Models\UnitSale;
use App\Exports\ExportProduct;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ProductsController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name,
        $stock,
        $price,
        $barcode,
        $cost,
        $alerts,
        $categoryid,
        $search,
        $image,
        $selected_id,
        $pageTitle,
        $componentName,
        $description,
        $desactivated = 0,
        $compositions = [],
        $selectedComponent = [],
        $product_compositions = [],
        $unit_sale = 'Elegir',
        $units_sale;

    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->categoryid = 'Elegir';
    }
    public function render()
    {
        if (strlen($this->search) > 0)
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                ->orderBy('products.name', 'asc')
                ->paginate($this->pagination);
        else
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.name', 'asc')
                ->paginate($this->pagination);

        $this->compositions = Product::select('id', 'name')->where('category_id', 1)->get();
        $this->units_sale = UnitSale::all();
        return view('livewire.products.component', [
            'data' => $products, 'categories' => Category::orderBy('name', 'asc')->get(),
        ])->extends('layouts.theme.app')
            ->section('content');
    }
    public function Store()
    {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];
        $messages = [
            'name.required' => 'Nombre del producto requerido',
            'name.unique' => 'Ya existe el nombre del producto',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
            'cost.required' => 'El costo es requerido',
            'price.required' => 'El precio es requerido',
            'stock.required' => 'El stock es requerido',
            'alerts.required' => 'Ingresa el valor mínimo en existencias',
            'categoryid.not_in' => 'Elige una categoría',
        ];

        $this->validate($rules, $messages);

        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' =>  $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid,
            'description' => $this->description,
            'unit_sale' => $this->unit_sale
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }
        foreach ($this->selectedComponent as $composition) {
            $product->compositions()->attach($composition);
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado');
    }

    public function Edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->description = $product->description;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->categoryid = $product->category_id;
        $this->image = null;
        $this->desactivated = $product->desactivated;
        $this->unit_sale = $product->unit_sale;
        $this->emit('modal-show', 'Show modal');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];
        $messages = [
            'name.required' => 'Nombre del producto requerido',
            'name.unique' => 'Ya existe el nombre del producto',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
            'cost.required' => 'El costo es requerido',
            'price.required' => 'El precio es requerido',
            'stock.required' => 'El stock es requerido',
            'alerts.required' => 'Ingresa el valor mínimo en existencias',
            'categoryid.not_in' => 'Elige una categoría',
        ];

        $this->validate($rules, $messages);

        $product = Product::find($this->selected_id);

        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid,
            'description' => $this->description,
            'desactivated' => $this->desactivated,
            'unit_sale' => $this->unit_sale
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products/', $customFileName);
            $imageTemp = $product->image; //img temporal
            $product->image = $customFileName;
            $product->save();

            if ($imageTemp != null) {
                if (file_exists('storage/products/' . $imageTemp)) {
                    unlink('storage/products/' . $imageTemp);
                }
            }
        }
        $this->resetUI();
        $this->emit('product-updated', 'Producto actualizado');
    }

    public function resetUI()
    {
        $this->name = "";
        $this->barcode = "";
        $this->cost = "";
        $this->price = "";
        $this->stock = "";
        $this->alerts = "";
        $this->search = "";
        $this->categoryid = "Elegir";
        $this->image = null;
        $this->selected_id = 0;
        $this->selectedComponent = [];
        $this->unit_sale = 'Elegir';
        $this->description = '';
    }

    protected $listeners = ['deleteRow' => 'Destroy','exportProducts'];

    public function Destroy(Product $product)
    {
        $imageTemp = $product->image;
        $product->delete();
        if ($imageTemp != null) {
            if (file_exists('storage/products/' . $imageTemp)) {
                unlink('storage/products/' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('product-deleted', 'Producto eliminado');
    }

    public function exportProducts(Request $request)
    {
        return Excel::download(new ExportProduct, 'Products.xlsx');
    }
}
