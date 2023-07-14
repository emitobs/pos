<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Sale;
use App\Models\Category;
use App\Models\Product;
use App\Models\Orders_Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PrintController extends Controller
{
    public $data;
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
            $rafflesActives = $detail->product->raffles->where('finished_date', null);
            if ($rafflesActives->count() > 0) {
                foreach ($rafflesActives as $rafleActive) {
                    $codeActive = $rafleActive->codes->where('printed_at', null);
                    if ($codeActive->count() > 0) {
                        $code = $rafleActive->codes->where('printed_at', null)->random();
                        array_push($codes, ['code' => $code->code, 'raffle' => $rafleActive->name]);
                    }
                };
                $code->printed_at = Carbon::now();
                $code->save();
            }

            $product = [
                'Product' => $detail->product->name,
                'Quantity' => $detail->quantity,
                'Price' => $detail->product->price,
                'Unit' => $detail->product->unit_sale,
                'Detail' => $detail->detail
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
            'rafflecodes' => $codes,
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
            'Products' => $xproducts,
            'DeliveryTime' => $order->delivery_time
        ];
        return $response;
    }

    public function getClients(Request $request)
    {
        $input = $request->all();
        $clients = Client::where(function ($query) use ($input) {
            $query->where('name', 'LIKE', '%' . $input['term']['term'] . '%')
                ->orWhere('telephone', 'LIKE', '%' . $input['term']['term'] . '%');
        })->where('disabled', 0)->get();
        $response = [];
        foreach ($clients as $client) {
            array_push($response, ['id' => $client->id, 'text' => $client->name . ' | ' . $client->telephone . ' | ' . $client->defaultAddress]);
        }
        return $response;
    }

    public function getProducts(Request $request)
    {
        $zone = $request->get('zone');
        $search = $request->get('term')['term'];
        $categoriesProducts = [];
        if ($zone == 1) {
            $categoriesProducts = Category::all();
        }

        if ($zone == 2) {
            $categoriesProducts = Category::where('processing_area', $zone)->get();
        }
        $categories = [];
        foreach ($categoriesProducts as $categorie) {
            array_push($categories, $categorie->id);
        }
        $products = Product::where('name', 'LIKE', '%' . $search . '%')->whereIn('category_id', $categories)->where('desactivated', 0)->get();
        $response = [];

        foreach ($products as $product) {
            array_push($response, ['id' => $product->barcode, 'text' => $product->name . ' | ' . $product->price . ' | ' . $product->stock]);
        }
        return $response;
    }
}
