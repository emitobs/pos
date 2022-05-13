<?php

namespace App\Http\Livewire;

use App\Models\Products_Service;
use App\Models\Sale;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Payroll;
use App\Models\SaleDetails;
use App\Models\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\ServerBag;

class ProcesarPedido extends Component
{

    public $service_to_finish, $searched_client, $products_for_invoicing = [], $total, $itemsQuantity, $products_in_invoice, $products_out_invoice, $cart_local, $payment_method = 'cash', $change = 0.00, $discount = 0.00, $cart_total, $rounding = 0.00, $total_result, $cash, $selected_client, $payWithHandy = 0, $debt = 0, $clients = [];
    protected $listeners = ['select_product', 'ACash', 'unselect_product'];

    public function mount(Request $request)
    {
        $cart_local = collect();
        $this->products_in_invoice = collect();
        $this->products_out_invoice = collect();
        $this->service_to_finish = Service::find($request->get('id'));
    }

    public function render()
    {
        $this->products_out_invoice = $this->service_to_finish->products->where('payed', 0)->diff($this->products_in_invoice);
        $this->products_in_invoice = $this->service_to_finish->products->where('payed', 0)->diff($this->products_out_invoice);
        return view('livewire.processServices.procesar-pedido', ['out' => $this->products_out_invoice, 'in' => $this->products_in_invoice])->extends('layouts.theme.app')
            ->section('content');
    }

    public function select_all_products()
    {
        $this->products_in_invoice = $this->service_to_finish->products;
    }

    public function select_product(Products_Service $product)
    {
        $this->products_in_invoice->push($product);
    }

    public function unselect_product($key)
    {
        $this->products_in_invoice->pull($key);
        //$this->products_out_invoice->push($product);
    }

    public function ACash($value)
    {
        $this->cash = ($value == 0 ? $this->products_in_invoice->sum('unit_price') : $value);
        $this->change = ($this->cash - $this->products_in_invoice->sum('unit_price'));
    }

    public function saveSale()
    {
        $cart = collect();
        $payroll = Payroll::with('sales')->where('isClosed', 0)
            ->where('responsible', auth()->user()->id)
            ->first();

        $client_id = $this->selected_client != null ? $this->selected_client : 1;
        $new_sale = Sale::create([
            'total' => $this->products_in_invoice->sum('unit_price'),
            'items' => $this->products_in_invoice->count(),
            'cash' => $this->cash,
            'change' => $this->change,
            'user_id' => Auth()->user()->id,
            'status' => 'Entregado',
            'client_id' => $client_id,
            'payWithHandy' => $this->payWithHandy,
            'payroll_id' => $payroll->id,
            'discount' => $this->discount,
            'dayid' => $payroll->sales->count(),
            'debt' => $this->debt,
            'rounding' => $this->rounding,

        ]);

        if ($new_sale) {
            $details = collect();
            foreach ($this->products_in_invoice as $product_in_invoice) {
                $xproduct = $details->where('product_id', $product_in_invoice->product_id)->first();
                if ($xproduct) {
                    $xproduct->quantity += $product_in_invoice->quantity;
                    $xproduct->price = $product_in_invoice->unit_price * $xproduct->quantity;
                } else {
                    $new_detail = new SaleDetails();
                    $new_detail->sale_id = $new_sale->id;
                    $new_detail->product_id = $product_in_invoice->product_id;
                    $new_detail->quantity = $product_in_invoice->quantity;
                    $new_detail->price = $product_in_invoice->unit_price * $new_detail->quantity;
                    $details->push($new_detail);
                }
                $product_in_invoice->payed = 1;
                $product_in_invoice->save();
            }
            foreach ($details as $detail) {
                $detail->save();
            }
            $this->service_to_finish = Service::find($this->service_to_finish->id);
            if ($this->service_to_finish->products->where('payed', 0)->count() == 0) {
                $service = Service::find($this->service_to_finish->id);
                if ($service) {
                    $service->finished_at = Carbon::now();
                    $service->save();
                    $table = Table::find($service->table->id);
                    $table->status = 'available';
                    $table->save();
                }
            }
            $this->emit('print-ticket', $new_sale->id);
            $this->emit('sale_saved');
            return Redirect('mesas');
        }
    }
}
