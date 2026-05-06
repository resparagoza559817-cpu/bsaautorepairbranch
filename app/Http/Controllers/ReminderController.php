<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\JobOrder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReminderController extends Controller
{
    // 🔹 Show page
    public function index()
    {
        $reminders = Reminder::orderBy('due_date', 'asc')->get();
        $jobOrders = DB::table('job_order')
            ->join('customer', 'job_order.customer_id', '=', 'customer.id')
            ->join('vehicle', 'job_order.vehicle_id', '=', 'vehicle.vehicle_id')
            ->select(
                'job_order.job_order_id',
                'customer.cust_name',
                'vehicle.make'
            )
            ->get();

        return view('reminders', compact('reminders', 'jobOrders'));
    }

    // 🔹 Store reminder
    public function store(Request $request)
    {
        Reminder::create([
            'job_order_id' => $request->job_order_id,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Reminder created!');
    }

    // 🔹 Mark as completed
    public function complete($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->status = 'completed';
        $reminder->save();

        return redirect()->back();
    }

    public function getByJob($id)
{
    $services = DB::table('job_order_services') // adjust if your table name is different
        ->join('services', 'job_order_services.service_id', '=', 'services.id')
        ->leftJoin('reminders', function ($join) {
            $join->on('services.id', '=', 'reminders.service_id');
        })
        ->where('job_order_services.job_order_id', $id)
        ->select(
            'services.id as service_id',
            'services.name as service_name',
            'services.interval',

            'reminders.id as reminder_id',
            'reminders.due_date',
            'reminders.status'
        )
        ->get();

    return response()->json($services);
}
}
