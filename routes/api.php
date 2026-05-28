<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TenantController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [AuthController::class, 'updateProfile']);
    
    // Units
    Route::get('/units', [TenantController::class, 'getUnits']);
    Route::get('/units/{id}', [TenantController::class, 'getUnitDetail']);
    
    // Bookings
    Route::get('/bookings', [TenantController::class, 'getBookings']);
    Route::post('/bookings', [TenantController::class, 'createBooking']);
    
    // Billings & Payment
    Route::get('/billings', [TenantController::class, 'getBillings']);
    Route::post('/billings/{id}/pay', [TenantController::class, 'payBilling']);
});

Route::post('/payments/notification', [App\Http\Controllers\Api\PaymentController::class, 'handleNotification']);
    
Route::middleware('auth:sanctum')->group(function () {
    // Complaints
    Route::get('/complaints', [TenantController::class, 'getComplaints']);
    Route::post('/complaints', [TenantController::class, 'createComplaint']);
    
    // Maintenances
    Route::get('/maintenances', [TenantController::class, 'getMaintenances']);
    Route::post('/maintenances', [TenantController::class, 'createMaintenance']);
    
    // Activities History
    Route::get('/history', [TenantController::class, 'getHistory']);
    
    // Calendar Sync
    Route::post('/bookings/{id}/sync', [TenantController::class, 'syncCalendar']);
    
    // Notifications
    Route::get('/notifications', [TenantController::class, 'getNotifications']);
});
