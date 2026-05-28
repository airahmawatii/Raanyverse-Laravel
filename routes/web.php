<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 🔥 TAMBAH INI
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\EstateController;

Route::get('/', function () {
    $units = \App\Models\Unit::with(['estate.region'])->where('status', 'available')->latest()->take(6)->get();
    return view('welcome', compact('units'));
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    $user = Auth::user();

    // 🔥 AUTOMATIC OVERDUE CHECK
    \App\Models\Billing::where('status', 'unpaid')
        ->where('due_date', '<', now()->toDateString())
        ->update(['status' => 'overdue']);

    // 🔥 AUTOMATIC RENTAL EXPIRY (AUTO-RELEASE)
    $expiredRentals = \App\Models\Rental::where('end_date', '<', now()->toDateString())->get();
    foreach($expiredRentals as $rental) {
        if ($rental->unit) {
            $rental->unit->update(['status' => 'available']);
        }
        $rental->delete(); // Clear active rental to free the unit
    }

    $totalUnits = \App\Models\Unit::count();
    $availableUnits = \App\Models\Unit::where('status', 'available')->count();
    $occupiedUnits = \App\Models\Unit::where('status', 'occupied')->count();
    $totalBookings = \App\Models\Booking::count();
    $totalBillings = \App\Models\Billing::count();
    $totalComplaints = \App\Models\Complaint::count();
    $totalMaintenances = \App\Models\Maintenance::count();
    $recentActivities = \App\Models\Activity::with('user')->orderBy('created_at', 'desc')->take(5)->get();

    // Data Keuangan (Admin & Owner)
    $totalOwners = \App\Models\User::where('role', 'owner')->count();
    $totalTenants = \App\Models\User::where('role', 'tenant')->count();
    $totalRevenue = \App\Models\Billing::where('status', 'paid')->sum('amount');
    $totalExpense = \App\Models\Expense::sum('amount');
    $netProfit = $totalRevenue - $totalExpense;

    $paidBillingsCount = \App\Models\Billing::where('status', 'paid')->count();
    $totalBillingsCount = \App\Models\Billing::count();
    $financialProgress = $totalBillingsCount > 0 ? round(($paidBillingsCount / $totalBillingsCount) * 100) : 0;

    // Data Tenant
    $myRoom = null;
    $myRoomEndDate = null;
    $myBillings = collect();
    $myUnpaidBillings = collect();
    $myComplaints = collect();
    
    if ($role === 'tenant') {
        $rental = \App\Models\Rental::where('tenant_id', $user->id)->with('unit')->first();
        $myRoom = $rental ? $rental->unit : null;
        $myRoomEndDate = $rental && $rental->end_date ? \Carbon\Carbon::parse($rental->end_date)->format('d F Y') : 'Sewa Terbuka (Bulanan)';
        
        $myBillings = \App\Models\Billing::where('tenant_id', $user->id)->orderBy('created_at', 'desc')->get();
        $myUnpaidBillings = $myBillings->where('status', 'unpaid');
        $myComplaints = \App\Models\Complaint::where('tenant_id', $user->id)->orderBy('created_at', 'desc')->get();
    }

    return view('dashboard', compact(
        'totalUnits', 'availableUnits', 'occupiedUnits', 'totalBookings',
        'totalBillings', 'totalComplaints', 'totalMaintenances', 'recentActivities',
        'role', 'myRoom', 'myRoomEndDate', 'myBillings', 'myUnpaidBillings', 'myComplaints',
        'totalOwners', 'totalTenants', 'totalRevenue', 'totalExpense', 'netProfit', 'financialProgress',
        'paidBillingsCount', 'totalBillingsCount'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');


// 🔐 SEMUA MASUK SINI
Route::middleware('auth')->group(function () {

    // bawaan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔥 FITUR KAMU
    Route::resource('regions', RegionController::class);
    Route::resource('estates', EstateController::class);
    Route::resource('units', UnitController::class);
    Route::get('/bookings/{booking}/contract', [BookingController::class, 'contract'])->name('bookings.contract');
    Route::resource('bookings', BookingController::class);
    Route::get('/billings/export', [BillingController::class, 'export'])->name('billings.export');
    Route::get('/billings/{billing}/snap', [BillingController::class, 'getSnapToken'])->name('billings.snap');
    Route::resource('billings', BillingController::class);
    Route::resource('complaints', ComplaintController::class);
    Route::resource('maintenances', MaintenanceController::class);
    Route::resource('users', UserController::class)->only(['index', 'destroy']);
    Route::post('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
    Route::resource('activities', ActivityController::class)->only(['index']);

    // 🔥 ENTERPRISE MODULES
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    Route::resource('utility_readings', \App\Http\Controllers\UtilityReadingController::class);
    Route::resource('facilities', \App\Http\Controllers\FacilityController::class);
    Route::resource('announcements', \App\Http\Controllers\AnnouncementController::class);
    Route::resource('leads', \App\Http\Controllers\LeadController::class);
    Route::resource('visitors', \App\Http\Controllers\VisitorController::class);
    Route::resource('parcels', \App\Http\Controllers\ParcelController::class);

    // 🔥 TAMBAHAN KHUSUS COMPLAINT
    Route::get('/complaints/{id}/approve', [ComplaintController::class, 'approve']);
    Route::get('/complaints/{id}/complete', [ComplaintController::class, 'complete']);
});


// JANGAN DIHAPUS
require __DIR__.'/auth.php';