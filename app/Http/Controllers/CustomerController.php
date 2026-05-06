<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function store(Request $request)
{
    // The form sends 'name' and 'phone', so we map them to the DB columns
    $customer = Customer::create([
        'cust_name' => $request->name, 
        'contact_number' => $request->phone,
        'address' => $request->address,
    ]);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'customer_id' => $customer->id]);
    }

    // Change 'userdash' to 'addcustomer' to stay on the same page
    return redirect()->route('addcustomer')->with('success', 'Customer added!');
}

    public function index() {
    $customers = \App\Models\Customer::all(); // This pulls the data[cite: 42]
    return view('addcustomer', compact('customers'));
}

public function update(Request $request, $id) // Added $id parameter for the URL[cite: 8]
{
    Customer::where('id', $id)->update([
        'cust_name' => $request->name,
        'contact_number' => $request->phone,
        'address' => $request->address
    ]);

    return back();
}

// app/Http/Controllers/CustomerController.php

public function delete($id)
{
    $customer = Customer::findOrFail($id);
    
    // This will delete the customer. 
    // Note: To handle vehicles, ensure your Migration has ->onDelete('cascade')
    // or manually delete them here if you haven't set up foreign keys yet.
    $customer->delete();

    return redirect()->route('addcustomer')->with('success', 'Customer and associated records removed.');
}
}