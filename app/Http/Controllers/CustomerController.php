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
        $fecha = Carbon::now()->timestamp;

        if ($request->picture != null) {
            $image_info = getimagesize($request->picture);
            $ext = (isset($image_info["mime"]) ? explode('/', $image_info["mime"])[1] : "");
            $exp = explode(',', $request->picture);
            $picture = $exp[1];
            $filename = "foto_{$request->name}_{$fecha}.{$ext}";
            Storage::disk('imgCustomer')->put($filename, base64_decode($picture));
            $customer->picture = $filename;
        }

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->token = `C_{$customer->id}_{$fecha}`;
        $customer->save();
        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        $customer->picture = getFileToBase64(Storage::disk('imgCustomer')->get($customer->picture));
        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        if ($request->has('picture')) {
            $picture = $request->picture;
            $ext = explode('/', mime_content_type($picture))[1];
            $exp = explode(',', $picture);
            $picture = $exp[1];
            $filename = "foto_{$customer->name}_".Carbon::now()->timestamp.".$ext";
            Storage::disk('imgCustomer')->put($filename, base64_decode($picture));
            $customer->picture = $filename;
        }

        $customer->update($request->all());
        return response()->json($customer, 200);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
