<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\JobOrderPartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerVehicleController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Redirect Root to Login ---
Route::get('/', function () {
    return redirect('/login');
});

// --- Authentication & Auto-Login Bypass ---
Route::get('/login', function () {
    $user = \App\Models\User::first(); 
    if ($user) {
        auth()->login($user);
        return redirect()->route('userdash');
    }
    return "No users found in database. Please run your migrations and seeders.";
})->name('login');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');

// --- Dashboard ---
Route::get('/userdash', [DashboardController::class, 'index'])->name('userdash');

// --- Job Orders & History ---
Route::get('/job-orders', [JobOrderController::class, 'index']);
Route::get('/joborderform', [JobOrderController::class, 'create']);
Route::post('/job-order/store', [JobOrderController::class, 'store'])->name('job-order.store');
Route::get('/serviceshistory', [JobOrderController::class, 'servicesHistory'])->name('serviceshistory');
Route::get('/job-order/pdf/{id}', [JobOrderController::class, 'generatePDF'])->name('job-order.pdf');

// --- Job Order Parts ---
Route::get('/job-order/{id}/parts', [JobOrderPartController::class, 'create']);
Route::post('/job-order/parts/store', [JobOrderPartController::class, 'store']);

// --- Vehicles ---
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/usermygarage', [VehicleController::class, 'index'])->name('usermygarage');
Route::post('/vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');
Route::post('/vehicles/update/{id}', [VehicleController::class, 'update'])->name('vehicles.update');
Route::post('/vehicles/delete/{id}', [VehicleController::class, 'destroy'])->name('vehicles.delete');

// --- Customers ---
Route::get('/addcustomer', [CustomerController::class, 'index'])->name('addcustomer');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::post('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update'); 
Route::post('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

// --- Customer Vehicles ---
Route::get('/customer-vehicles', [CustomerVehicleController::class, 'index']);
Route::get('/viewcustomervehicles', [CustomerVehicleController::class, 'index']);

// --- Staff / Mechanics ---
Route::get('/addmechanic', [StaffController::class, 'index'])->name('addmechanic.index');
Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
// Change these lines in routes/web.php
Route::post('/staff/update', [StaffController::class, 'update'])->name('staff.update');
Route::post('/staff/delete', [StaffController::class, 'delete'])->name('staff.delete');
// --- Services ---
Route::get('/addservices', [ServiceController::class, 'index'])->name('services.index');
Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');
Route::post('/services/update', [ServiceController::class, 'update'])->name('services.update');
Route::post('/services/delete', [ServiceController::class, 'destroy'])->name('services.delete');
// --- Parts & Stock Inventory ---
Route::get('/stockin', [PartsController::class, 'index'])->name('stockin');
Route::post('/stockin/store', [PartsController::class, 'store'])->name('stockin.store');
Route::post('/stockin/update/{id}', [PartsController::class, 'update'])->name('stockin.update');
Route::post('/stockin/delete/{id}', [PartsController::class, 'delete'])->name('stockin.delete');
Route::post('/stock-adjust/{id}', [PartsController::class, 'adjustStock']);

// --- Suppliers (FIXED: Added ->name()) ---
Route::get('/addsupplier', [SupplierController::class, 'index'])->name('suppliers.index');
Route::post('/suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
Route::post('/suppliers/update/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
Route::post('/suppliers/delete/{id}', [SupplierController::class, 'delete'])->name('suppliers.delete');

// --- Reminders ---
Route::get('/reminders', [ReminderController::class, 'index']);
Route::post('/reminders/store', [ReminderController::class, 'store']);
// In Laravel, DELETE operations should typically use POST or DELETE methods for security, but keeping consistency with your current structure.
Route::get('/reminders/complete/{id}', [ReminderController::class, 'complete']);
Route::get('/reminders/by-job/{id}', function ($id) {
    return \App\Models\Reminder::where('job_order_id', $id)->get();
});