<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\StockIn;
use App\Models\Supplier; 
use Illuminate\Support\Facades\DB;

class PartsController extends Controller
{
    public function index() {
        $parts = Part::all(); 
        $suppliers = Supplier::all();
        $history = StockIn::with(['part', 'supplier'])->orderBy('stock_in_arrived', 'desc')->get();
        return view('stockin', compact('parts', 'suppliers', 'history'));
    }

   public function store(Request $request)
{
    $request->validate([
        'part_name'         => 'required|string',
        'price'             => 'required|numeric',
        'quantity_received' => 'required|integer|min:1',
        'supplier_id'       => 'required|exists:supplier,supplier_id',
        'cost_per_unit'     => 'required|numeric',
        'stock_in_date'     => 'required'
    ]);

    DB::transaction(function () use ($request) {
        // Use updateOrCreate: if part_id exists, update it. If not, create a new one using part_name[cite: 15, 17].
        $part = Part::updateOrCreate(
            ['part_id' => $request->part_id], 
            [
                'part_name'   => $request->part_name,
                'description' => $request->description,
                'price'       => $request->price,
            ]
        );
        
        $part->increment('stock_qty', $request->quantity_received);

        StockIn::create([
            'part_id'           => $part->part_id, // Use the ID from the part we just found or created[cite: 11, 15]
            'supplier_id'       => $request->supplier_id,
            'quantity_received' => $request->quantity_received,
            'cost_per_unit'     => $request->cost_per_unit,
            'stock_in_arrived'  => $request->stock_in_date,
        ]);
    });

    return redirect()->route('stockin')->with('success', 'Stock updated successfully!');
}
}