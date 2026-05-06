<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\ViewJobOrder;
use App\Models\Reminder;
use Carbon\Carbon;

class DashboardController extends Controller
{
   public function index()
{
    // 🔢 Stats
    $totalVehicles = Vehicle::count();
    $totalJobOrders = ViewJobOrder::count();
    
    $pendingCount = Reminder::where('status', 'pending')
        ->whereDate('due_date', '>=', Carbon::today())
        ->count();

    $overdueCount = Reminder::where('status', 'pending')
        ->whereDate('due_date', '<', Carbon::today())
        ->count();

    $totalAlerts = $pendingCount + $overdueCount;

        // 📊 Weekly Data (Grouped by YearWeek)
$weeklyOrders = DB::table('job_order')
    ->select(DB::raw('YEARWEEK(date_issued, 1) as period'), DB::raw('COUNT(*) as total'))
    ->groupBy('period')
    ->orderBy('period')
    ->get(); 
        // 📅 Daily Data (Last 7 days)[cite: 8]
       // 📅 Daily Data (Last 7 days)
$dailyOrders = DB::table('job_order')
    ->select(DB::raw('DATE(date_issued) as period'), DB::raw('COUNT(*) as total'))
    ->where('date_issued', '>=', Carbon::now()->subDays(7))
    ->groupBy('period')
    ->orderBy('period')
    ->get();

        // Prepare for JSON output
$weeklyLabels = $weeklyOrders->map(fn($o, $i) => "Week " . ($i + 1));
$weeklyCounts = $weeklyOrders->pluck('total');

$dailyLabels = $dailyOrders->map(fn($o) => Carbon::parse($o->period)->format('D (M d)'));
$dailyCounts = $dailyOrders->pluck('total');
        return view('userdash', compact(
            'totalVehicles', 'totalJobOrders', 'pendingCount', 'overdueCount', 'totalAlerts',
            'weeklyLabels', 'weeklyCounts', 'dailyLabels', 'dailyCounts'
        ));
    }
}