<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Customer;

class VehicleController extends Controller
{
    public function index() {
        // Ensure we eager load 'customer' to avoid N+1 issues[cite: 16]
        $vehicles = Vehicle::with('customer')->get();
        $customers = Customer::all(); 
        return view('usermygarage', compact('vehicles', 'customers'));
    }

    public function store(Request $request) {
        Vehicle::create([
            'plate_number'  => $request->plate_number,
            'make'          => $request->make,
            'engine_model'  => $request->engine_model, 
            'customer_id'   => $request->customer_id
        ]);
        return back()->with('success', 'Vehicle registered!');
    }

    public function update(Request $request, $id) 
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update([
            'plate_number'  => $request->plate_number,
            'make'          => $request->make,
            'engine_model'  => $request->engine_model,
            'customer_id'   => $request->customer_id
        ]);
        return back()->with('success', 'Vehicle updated successfully!');
    }

    public function destroy($id) 
    {
        Vehicle::findOrFail($id)->delete();
        return back()->with('success', 'Vehicle removed from garage.');
    }
}