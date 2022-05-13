<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Orders_Services;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $sale = Sale::find($id);
        $products = [];
        $codes = [];
        foreach ($sale->details as $detail) {
            if ($detail->product->raffleActive) {
                $code = $detail->product->raffleActive->get_random_code;
                array_push($codes, $code->code);
                $code->printed_at = Carbon::now();
                $code->save();
            }
            $product = [
                'Product' => $detail->product->name,
                'Quantity' => $detail->quantity,
                'Price' => $detail->product->price,
                'Unit' => $detail->product->unit_sale
            ];
            array_push($products, $product);
        }

        $response = [
            'Id' => $sale->id,
            'Date' => $sale->created_at,
            'Address' => $sale->address,
            'DeliveryTime' => $sale->deliveryTime,
            'SubTotal' => $sale->subtotal,
            'Total' => $sale->total,
            'Discount' => $sale->discount,
            'Cash' => $sale->cash,
            'Change' => $sale->change,
            'Client' => $sale->client->name,
            'Clarifications' => $sale->clarifications,
            'SaleDetails' => $products,
            'Rounding' => $sale->rounding,
            'PayWithHandy' => $sale->paywithhandy,
            'rafflecodes' => [],
            'Debt' => $sale->debt
        ];
        return response()->json($response);
    }

    public function print_order($id)
    {
        $order = Orders_Services::find($id);
        //dd($order,$order->products,$order->service);
        $xproducts = collect();
        foreach ($order->products as $product) {
            $zone = "";
            switch ($product->product->category->processing_area) {
                case 1:
                    $zone = 'Cocina';
                    break;
                case 2:
                    $zone = 'Cantina';
                    break;
            }
            $xproducts->push(
                [
                    "ProductName" => $product->product->name,
                    'Zone' => $zone,
                    'Detail' => $product->detail
                ]
            );
        }
        $response = [
            'id' => $order->id,
            'Table' => $order->service->table_id,
            'Products' => $xproducts
        ];
        return $response;
    }
}
