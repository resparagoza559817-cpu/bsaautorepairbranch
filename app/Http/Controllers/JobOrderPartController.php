<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\JobOrderPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobOrderPartController extends Controller
{
    public function create($jobOrderId){
    $parts = Part::all();

    return view('job_order.parts', compact('parts', 'jobOrderId'));
    }

    public function store(Request $request)
{
    foreach ($request->parts as $index => $partId) {

        $qty = $request->qty[$index];

        // 🔥 GET CURRENT STOCK
        $stock = DB::table('view_part_stock')
            ->where('part_id', $partId)
            ->value('stock');

        // ❌ PREVENT NEGATIVE STOCK
        if ($qty > $stock) {
            return back()->with('error', 'Not enough stock for selected part');
        }

        // ✅ SAVE JOB ORDER PART
        DB::table('job_order_parts')->insert([
            'job_order_id' => session('job_order_id'), // adjust if needed
            'part_id' => $partId,
            'quantity' => $qty
        ]);

        // ✅ DEDUCT STOCK (IMPORTANT)
        DB::table('stock_ins')->insert([
            'part_id' => $partId,
            'quantity_received' => -$qty, // 🔥 NEGATIVE = STOCK OUT
            'stock_in_arrived' => now()
        ]);
    }

    return back()->with('success', 'Parts added');
}


public function showForm()
{
    $parts = Part::all();

    return view('joborderform', compact('parts'));
}


}
