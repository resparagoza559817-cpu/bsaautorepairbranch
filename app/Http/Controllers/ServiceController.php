<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('addservices', compact('services'));
    }

    public function store(Request $request)
    {
        Service::create([
            'job_desc'       => $request->job_desc,
            'price'          => $request->price,
            'interval_value' => $request->interval_value,
            'interval_unit'  => $request->interval_unit,
        ]);
        return redirect()->back();
    }

    public function update(Request $request)
    {
        Service::where('service_id', $request->service_id)->update([
            'job_desc'       => $request->job_desc,
            'price'          => $request->price,
            'interval_value' => $request->interval_value,
            'interval_unit'  => $request->interval_unit,
        ]);
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        Service::where('service_id', $request->service_id)->delete();
        return redirect()->back();
    }
}

