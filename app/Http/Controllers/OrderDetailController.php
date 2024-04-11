<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
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
