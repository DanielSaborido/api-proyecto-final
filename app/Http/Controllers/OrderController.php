<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->order_date = Carbon::parse($request->order_date);

        $order->save();

        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        return response()->json($order);
    }

    public function showOrderByCustomer($customerId)
    {
        $orders = Order::where('customer_id', $customerId)->get();
        return response()->json($orders);
    }

    public function showActualOrderByCustomer($customerId)
    {
        $order = Order::where('customer_id', $customerId)->where('status','pending')->first();
        return response()->json($order);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response()->json($order, 200);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
