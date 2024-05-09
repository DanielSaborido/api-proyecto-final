<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $customer = new Customer;

        if ($request->foto != null) {
            $image_info = getimagesize($request->foto);
            $ext = (isset($image_info["mime"]) ? explode('/', $image_info["mime"])[1] : "");
            $exp = explode(',', $request->foto);
            $foto = $exp[1];
            $fecha = Carbon::now()->timestamp;
            $filename = "foto_{$request->name}_{$fecha}.{$ext}";
            Storage::disk('imgCustomer')->put($filename, base64_decode($foto));
            $customer->foto = $filename;
        }

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->save();
        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return response()->json($customer, 200);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
