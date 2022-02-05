<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Sale;
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
        foreach ($sale->details as $detail) {
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
        ];
        return response()->json($response);
    }
}
