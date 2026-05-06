<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerVehicleController extends Controller
{
    public function index()
    {
        $vehicles = DB::table('vehicle')
            ->join('customer', 'vehicle.customer_id', '=', 'customer.id')
            ->select(
                'vehicle.*',
                'customer.cust_name',
                'customer.contact_number'
            )
            ->get();

        return view('viewcustomervehicles', compact('vehicles'));
    }
}
