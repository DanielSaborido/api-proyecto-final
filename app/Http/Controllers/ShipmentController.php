<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::all();
        return response()->json($shipments);
    }

    public function store(Request $request)
    {
        $shipment = Shipment::create($request->all());
        return response()->json($shipment, 201);
    }

    public function show(Shipment $shipment)
    {
        return response()->json($shipment);
    }

    public function update(Request $request, Shipment $shipment)
    {
        $shipment->update($request->all());
        return response()->json($shipment, 200);
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return response()->json(null, 204);
    }
}
