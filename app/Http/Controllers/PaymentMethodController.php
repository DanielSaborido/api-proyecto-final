<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return response()->json($paymentMethods);
    }

    public function store(Request $request)
    {
        $paymentMethod = PaymentMethod::create($request->all());
        return response()->json($paymentMethod, 201);
    }

    public function show(PaymentMethod $paymentMethod)
    {
        return response()->json($paymentMethod);
    }

    public function showPaymentMethodByCustomer($customerId)
    {
        $paymentMethods = PaymentMethod::where('customer_id', $customerId)->get();

        if ($paymentMethods->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No payment methods found for the provided customer ID.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'paymentMethods' => $paymentMethods
        ]);
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->all());
        return response()->json($paymentMethod, 200);
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return response()->json(null, 204);
    }
}
