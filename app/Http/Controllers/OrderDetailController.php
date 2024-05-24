<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::all();
        return response()->json($orderDetails);
    }

    public function store(Request $request)
    {
        $orderDetail = OrderDetail::create($request->all());
        return response()->json($orderDetail, 201);
    }

    public function show(OrderDetail $orderDetail)
    {
        return response()->json($orderDetail);
    }

    public function showProductsByOrder($orderId)
    {
        $products = OrderDetail::where('order_id', $orderId)->get();

        $products = $products->map(function ($product) {
            $productData = Product::find($product->custommer_id);
            return [
                $product->id = $product->id,
                $product->quantity = $product->quantity,
                $product->product_name = $productData->name,
                $product->total_cost = ($productData->price*$product->quantity),
            ];
        });
        return response()->json($products);
    }

    public function update(Request $request, OrderDetail $orderDetail)
    {
        $orderDetail->update($request->all());
        return response()->json($orderDetail, 200);
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();
        return response()->json(null, 204);
    }
}
