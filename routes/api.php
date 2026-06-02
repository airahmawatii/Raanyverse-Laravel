<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\PaymentController;

// =====================================================================
// PUBLIC ROUTES (no auth required)
// =====================================================================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/google-login', [AuthController::class, 'googleLogin']);

// Duitku payment webhook — must be public (called by Duitku servers)
Route::post('/payments/notification', [PaymentController::class, 'handleNotification']);

// =====================================================================
// PROTECTED ROUTES (Sanctum token required)
// =====================================================================
Route::middleware('auth:sanctum')->group(function () {

    // --- Auth & Profile ---
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [AuthController::class, 'updateProfile']);

    // --- Units ---
    Route::get('/units', [TenantController::class, 'getUnits']);
    Route::get('/units/{id}', [TenantController::class, 'getUnitDetail']);

    // --- Bookings ---
    Route::get('/bookings', [TenantController::class, 'getBookings']);
    Route::post('/bookings', [TenantController::class, 'createBooking']);
    Route::delete('/bookings/{id}', [TenantController::class, 'cancelBooking']);
    Route::post('/bookings/{id}/sync', [TenantController::class, 'syncCalendar']);

    // --- Billings & Payment ---
    Route::get('/billings', [TenantController::class, 'getBillings']);
    Route::post('/billings/{id}/pay', [TenantController::class, 'payBilling']);

    // --- Complaints ---
    Route::get('/complaints', [TenantController::class, 'getComplaints']);
    Route::post('/complaints', [TenantController::class, 'createComplaint']);

    // --- Maintenances ---
    Route::get('/maintenances', [TenantController::class, 'getMaintenances']);
    Route::post('/maintenances', [TenantController::class, 'createMaintenance']);

    // --- Facilities ---
    Route::get('/facilities', [TenantController::class, 'getFacilities']);
    Route::post('/facilities/{id}/book', [TenantController::class, 'bookFacility']);
    Route::get('/facility-bookings', [TenantController::class, 'getFacilityBookings']);
    Route::delete('/facility-bookings/{id}', [TenantController::class, 'cancelFacilityBooking']);

    // --- Announcements ---
    Route::get('/announcements', [TenantController::class, 'getAnnouncements']);

    // --- History ---
    Route::get('/history', [TenantController::class, 'getHistory']);

    // --- Notifications ---
    Route::get('/notifications', [TenantController::class, 'getNotifications']);
    Route::patch('/notifications/{id}/read', [TenantController::class, 'markNotificationRead']);
});
