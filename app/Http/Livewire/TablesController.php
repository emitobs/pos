<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\Orders_Services;
use App\Models\Products_Service;
use App\Models\Service;
use App\Models\Table;
use App\Models\Unit;
use Carbon\Carbon;
use Facade\Ignition\Tabs\Tab;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class TablesController extends Component
{
    public $table_selected, $search, $categoriesProducts, $searched_products, $selected_product, $units_quantity, $detail, $cart_local = [], $attendant, $service_to_finish;

    public function render()
    {
        $categories = Category::all();
        $products = Product::all();
        $tables = Table::all();
        if (strlen($this->search) > 0) {
            $this->searched_products = Product::where('name', 'LIKE', '%' . $this->search . '%')->where('desactivated', 0)->get();
        }
        return view('livewire.tables.tables-controller', ['tables' => $tables, 'products' => $products, 'categories' => $categories])->extends('layouts.theme.app')
            ->section('content');;
    }

    protected $listeners = ['create_table', 'select_product' => 'select_product', 'add_product_to_cart', 'end_service', 'confirm_end_of_service'];

    public function create_table()
    {
        Table::create([]);
    }

    public function select_attendant(Table $table)
    {
        if ($table) {
            $this->table_selected = $table;
            $this->emit('set_attendant');
        }
    }

    public function init_service()
    {
        $table = Table::find($this->table_selected->id);
        $table->status = 'busy';
        $table->save();
        $new_service = Service::create([
            'attendant' => $this->attendant,
            'table_id' => $this->table_selected->id,
        ]);
        $this->render();
        $this->emit('noty', 'Servicio iniciado');
    }

    public function end_service(Service $service)
    {
        $service->finished_at = Carbon::now();
        $service->save();
        $service->table->status = 'available';
        $service->table->save();
    }

    public function select_table(Table $table)
    {
        $this->table_selected = $table;
        $this->emit('show-modal');
    }

    public function select_product($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();
        if ($product) {
            $this->selected_product = $product;
            if ($product->unit_sale == 1) {
                $this->emit('set_units');
            } else if ($product->unit_sale == 2) {

                $this->emit('set_kg');
            } else {
                $this->ScanCode($product->barcode);
            }
        }
    }

    public function add_product_to_cart($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();
        if ($product) {
            if (!$this->units_quantity) {
                $this->units_quantity = 1;
            }
            //$this->units_quantity == null ? 1 : $this->units_quantity;
            // $product_service = [
            //     'quantity' => $this->units_quantity,
            //     'product' => $product->name,
            //     'detail' => $this->detail,
            //     'price_unit' => $product->price
            // ]
            for ($i = 0; $i < $this->units_quantity; $i++) {
                $product_service = Products_Service::create([
                    'product_id' => $product->id,
                    'product' => $product->name,
                    'detail' => $this->detail,
                    'unit_price' => $product->price,
                    'service_id' => $this->table_selected->current_service->id,
                ]);
            }
        }
    }

    public function confirm_end_of_service()
    {

        $service = Service::find($this->service_to_finish);
        if ($service && $service->products->where('payed', 0)->count() > 0) {
            return Redirect::route('endservice', ['id' => $this->service_to_finish]);
        } else {
            $table = Table::find($service->table->id);
            if ($table) {
                $table->status = 'available';
                $table->save();
            }
            $service->delete();
            return Redirect::route('mesas');
        }
    }

    public function generate_order()
    {

        if($this->table_selected->current_service->products->where('order_id', null)->count() > 0){
            $new_order = Orders_Services::create([
                'service_id' => $this->table_selected->current_service->id,
                'delivery_time' => date('G:i', strtotime("+30 minutes", strtotime(date('G:i'))))
            ]);
            foreach ($this->table_selected->current_service->products->where('order_id', null) as $ordered_product) {
                $ordered_product->order_id = $new_order->id;
                $ordered_product->save();
            }
            $this->emit('print-order', $new_order->id);
        }else{
            $this->emit('empty-cart');
        }

    }


    public function decreaseQty(Products_Service $product_service)
    {
        $product_service->quantity -= 1;
        if ($product_service->quantity < 1) {
            $product_service->delete();
        } else {
            $product_service->total = $product_service->unit_price * $product_service->quantity;
            $product_service->save();
        }
    }

    public function addProduct()
    {
        //se chequea en que unidad se ingreso la cantidad
        if ($this->selected_Product) {
            if ($this->kgs_quantity > 0) {
                if ($this->kg_unit == 'kgs')
                    //si es kgs se pasa el valor entero
                    $this->ScanCode($this->selected_Product->barcode, $this->kgs_quantity);
                //si es money transformar a peso
                else if ($this->kg_unit == 'money') {
                    //plata dividirla entre precio
                    $result = $this->kgs_quantity / $this->selected_Product->price;
                    $this->ScanCode($this->selected_Product->barcode, $result);
                } else
                    //si es grs
                    $this->ScanCode($this->selected_Product->barcode, ($this->kgs_quantity / 1000));
            } else {
                $this->ScanCode($this->selected_Product->barcode, $this->units_quantity);
            }
        } else {
            dd('error');
        }
    }

    public function ScanCode($barcode, $cant = 1)
    {
        $count = 0;
        $product = Product::where('barcode', $barcode)->firstOrFail();
        if ($product) {
            $founded = false;
            while (!$founded && $count < count($this->cart_local)) {
                if ($this->cart_local[$count]['product_barcode'] == $product->barcode) {
                    $founded = true;
                    if ($this->cart_local[$count]['unit'] == "Kg") {
                        array_push($this->cart_local, [
                            'product_id' => $product->id,
                            'product_barcode' => $product->barcode,
                            'product_name' => $product->name,
                            'product_price' => $product->price,
                            'unit' => $product->unitSale->unit,
                            'quantity' => $cant,
                            'total' => $cant * $product->price,
                        ]);
                        $this->refreshTotal();
                        $this->emit('scan-ok', 'Producto agregado');
                    } else {
                        $this->cart_local[$count]['quantity'] += $cant;
                        $this->cart_local[$count]['total'] = $this->cart_local[$count]['quantity'] * $this->cart_local[$count]['product_price'];
                        $this->refreshTotal();
                        $this->emit('scan-ok', 'Producto agregado');
                    }
                } else {
                    $count++;
                }
            }
            if (!$founded) {
                array_push($this->cart_local, [
                    'product_id' => $product->id,
                    'product_barcode' => $product->barcode,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'unit' => $product->unitSale->unit,
                    'quantity' => $cant
                ]);
                $this->refreshTotal();
                $this->emit('scan-ok', 'Producto agregado');
            }
        } else {
            $this->emit('scan-notfound', 'El producto no está registrado');
        }
        $this->kgs_quantity = 0;
    }
    public function resetUI()
    {
        $this->table_selected = null;
    }
}
