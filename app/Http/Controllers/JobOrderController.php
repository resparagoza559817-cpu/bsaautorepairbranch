<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOrder;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Staff;
use App\Models\Part;
use App\Models\Service;
use App\Models\ViewJobOrder; // Added to fix model undefined errors
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobOrderController extends Controller
{
    /**
     * Display the history of all services/job orders.
     */
  public function servicesHistory() 
{
    // Now that the view is fixed, we can sort by date_issued again
    $history = ViewJobOrder::orderBy('date_issued', 'desc')->get();
    
    return view('serviceshistory', compact('history'));
}

    public function create() {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $services = Service::all();
        $mechanics = Staff::where('role', 'mechanic')->get();
        $parts = Part::all();

        return view('joborderform', compact('customers', 'vehicles', 'services', 'mechanics', 'parts'));
    }

    public function store(Request $request) {
        $request->validate([
            'customer_id' => 'required',
            'vehicle_id' => 'required',
            'staff_id' => 'required',
            'date_issued' => 'required|date',
        ]);

        $job = JobOrder::create([
            'customer_id' => $request->customer_id,
            'vehicle_id'  => $request->vehicle_id,
            'staff_id'    => $request->staff_id, 
            'date_issued' => $request->date_issued,
            'status'      => 'Pending',
            'total_cost'  => $request->total_cost,
        ]);

        if ($request->services) {
            foreach ($request->services as $serviceId) {
                DB::table('job_order_services')->insert([
                    'job_order_id' => $job->job_order_id,
                    'service_id'   => $serviceId,
                    'created_at'   => now()
                ]);
            }
        }

        if ($request->parts) {
            foreach ($request->parts as $index => $partId) {
                DB::table('job_order_parts')->insert([
                    'job_order_id' => $job->job_order_id,
                    'part_id'      => $partId,
                    'quantity'     => $request->qty[$index],
                    'created_at'   => now()
                ]);
            }
        }

        return redirect()->route('userdash')->with('success', 'Job Order added successfully!');
    }

    public function generatePDF($id) 
    {
        $job = JobOrder::findOrFail($id);
        $view = DB::table('view_job_order_master')->where('job_order_id', $id)->first();

        // Change 'services.services_name' to 'services.service_name'
$services = DB::table('job_order_services')
    ->join('services', 'job_order_services.service_id', '=', 'services.service_id')
    ->where('job_order_id', $id)
    ->select('services.job_desc as name', 'services.price') // Use job_desc here
    ->get();

        $parts = DB::table('job_order_parts')
            ->join('part', 'job_order_parts.part_id', '=', 'part.part_id')
            ->where('job_order_id', $id)
            ->select('part.part_name as name', 'job_order_parts.quantity as qty', 'part.price')
            ->get();

        $services_total = $services->sum('price');
        $parts_total = $parts->sum(fn($p) => $p->price * $p->qty);

        return view('pdf.job_order', compact('job', 'view', 'services', 'parts', 'services_total', 'parts_total'));
    }
}