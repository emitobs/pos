<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;

class DelivererController extends Controller
{
    public function assignOrder(Request $request)
    {
        if (Auth::user()) {
            $order = Sale::where('unique_code', $request->code)->first();
            $order->delivery_id = Auth::user()->id;
            $order->save();
            return response()->json(['status' => 'ok'], 200);
        }
    }
}
