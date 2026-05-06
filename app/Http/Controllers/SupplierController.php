<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('addsupplier', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate(['supplier_name' => 'required']);
        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier added!');
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated!');
    }

    public function delete($id)
    {
        Supplier::destroy($id);
        return redirect()->route('suppliers.index')->with('success', 'Supplier removed!');
    }
}