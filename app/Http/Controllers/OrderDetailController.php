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
        $orderDetail = new OrderDetail();
        $orderDetail->order_id = $request->order_id;
        $orderDetail->product_id = $request->product_id;
        $orderDetail->quantity = $request->quantity;
        $orderDetail->unit_price = $request->unit_price;
        $orderDetail->subtotal = $request->quantity*$request->unit_price;

        $orderDetail->save();

        $product = Product::find($request->product_id);
        $product->update([
            'quantity' => $product->quantity - $request->quantity
        ]);

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
                'id' => $product->id,
                'quantity' => $product->quantity,
                'product_name' => $productData->name,
                'total_cost' => ($productData->price*$product->quantity),
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
