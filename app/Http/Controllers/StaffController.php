<?php

namespace App\Http\Controllers;

use App\Models\Staff; 
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::all(); 
        return view('addmechanic', compact('staff'));
    }

    public function store(Request $request)
    {
        // Validation ensures 'name' is never null before hitting the DB
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Staff::create([
            'name'           => $request->name,
            'role'           => $request->role,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Staff::where('id', $request->id)->update([
            'name'           => $request->name,
            'role'           => $request->role,
            'contact_number' => $request->contact_number
        ]);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        Staff::where('id', $request->id)->delete();
        return redirect()->back();
    }
}