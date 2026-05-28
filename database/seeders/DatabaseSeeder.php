<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Unit;
use App\Models\Booking;
use App\Models\Rental;
use App\Models\Billing;
use App\Models\Complaint;
use App\Models\Maintenance;
use App\Models\Activity;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $superAdmin = User::create([
            'name' => 'Admin Properti',
            'email' => 'admin@kost.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // 2. Create Owner
        $owner = User::create([
            'name' => 'Pemilik Properti',
            'email' => 'owner@kost.com',
            'password' => Hash::make('password'),
            'role' => 'owner'
        ]);

        // 3. Create Tenants
        $tenant1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@kost.com',
            'password' => Hash::make('password'),
            'role' => 'tenant'
        ]);

        $tenant2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@kost.com',
            'password' => Hash::make('password'),
            'role' => 'tenant'
        ]);

        // 3a. Create Regions
        $region1 = \App\Models\Region::create([
            'name' => 'Jabodetabek'
        ]);

        $region2 = \App\Models\Region::create([
            'name' => 'Bandung Raya'
        ]);

        // 3b. Create Estates
        $estate1 = \App\Models\Estate::create([
            'region_id' => $region1->id,
            'name' => 'Grand Galaxy City',
            'address' => 'Jl. Boulevard Raya, Bekasi',
            'description' => 'Kawasan hunian premium di Bekasi Selatan'
        ]);

        $estate2 = \App\Models\Estate::create([
            'region_id' => $region2->id,
            'name' => 'Kota Baru Parahyangan',
            'address' => 'Padalarang, Kabupaten Bandung Barat',
            'description' => 'Kota mandiri berwawasan lingkungan'
        ]);

        // 3c. Create Units (Properties)
        $unit1 = Unit::create([
            'estate_id' => $estate1->id,
            'name' => 'Cluster Mutiara Blok A1',
            'type' => 'Standard',
            'property_type' => 'Rumah',
            'price' => 1500000, // Monthly
            'status' => 'occupied'
        ]);

        $unit2 = Unit::create([
            'estate_id' => $estate1->id,
            'name' => 'Ruko Grand Boulevard B2',
            'type' => 'VIP',
            'property_type' => 'Ruko',
            'price' => 2500000, // Monthly
            'status' => 'occupied'
        ]);

        $unit3 = Unit::create([
            'estate_id' => $estate2->id,
            'name' => 'Cluster Diamond Blok C3',
            'type' => 'Standard',
            'property_type' => 'Rumah',
            'price' => 1500000, // Monthly
            'status' => 'available'
        ]);

        $unit4 = Unit::create([
            'estate_id' => $estate2->id,
            'name' => 'Ruko Premium D4',
            'type' => 'VIP',
            'property_type' => 'Ruko',
            'price' => 2500000, // Monthly
            'status' => 'available'
        ]);

        // 4. Create Rentals (Occupancy)
        Rental::create([
            'tenant_id' => $tenant1->id,
            'unit_id' => $unit1->id,
            'start_date' => Carbon::now()->subMonths(2),
            'end_date' => null
        ]);

        Rental::create([
            'tenant_id' => $tenant2->id,
            'unit_id' => $unit2->id,
            'start_date' => Carbon::now()->subMonths(1),
            'end_date' => null
        ]);

        // 5. Create Bookings
        $booking = Booking::create([
            'tenant_id' => $tenant1->id, // Budi wants to move or book another for a friend, wait let's use a new user
            'unit_id' => $unit3->id,
            'start_date' => Carbon::now()->addDays(5),
            'end_date' => Carbon::now()->addMonths(6)->addDays(5),
            'status' => 'pending'
        ]);

        // 6. Create Billings
        Billing::create([
            'tenant_id' => $tenant1->id,
            'unit_id' => $unit1->id,
            'amount' => 1500000,
            'period' => Carbon::now()->format('F Y'),
            'status' => 'unpaid'
        ]);

        Billing::create([
            'tenant_id' => $tenant2->id,
            'unit_id' => $unit2->id,
            'amount' => 2500000,
            'period' => Carbon::now()->subMonth()->format('F Y'),
            'status' => 'paid'
        ]);

        // 7. Create Complaints
        Complaint::create([
            'tenant_id' => $tenant1->id,
            'unit_id' => $unit1->id,
            'description' => 'Atap bocor di ruang keluarga',
            'status' => 'pending'
        ]);

        // 8. Create Maintenance
        Maintenance::create([
            'tenant_id' => $tenant2->id,
            'unit_id' => $unit2->id,
            'description' => 'Pipa air wastafel rusak',
            'status' => 'completed'
        ]);

        // 9. Create Activities
        Activity::create([
            'user_id' => $tenant2->id,
            'action' => 'Payment Simulation Completed',
            'module' => 'billing',
            'description' => 'Tenant Siti Aminah paid bill for Ruko'
        ]);

        Activity::create([
            'user_id' => $tenant1->id,
            'action' => 'Booking Submitted',
            'module' => 'booking',
            'description' => 'Tenant Budi Santoso booked Cluster Diamond'
        ]);

        // 10. Create Facilities
        $facility1 = \App\Models\Facility::create([
            'estate_id' => $estate1->id,
            'name' => 'Clubhouse Mutiara',
            'description' => 'Kolam renang dan ruang santai untuk warga cluster.',
            'open_time' => '07:00:00',
            'close_time' => '21:00:00',
            'is_bookable' => true,
            'max_capacity' => 20,
            'booking_fee' => 0
        ]);

        $facility2 = \App\Models\Facility::create([
            'estate_id' => $estate2->id,
            'name' => 'Lapangan Tenis',
            'description' => 'Lapangan tenis outdoor dengan lampu malam.',
            'open_time' => '06:00:00',
            'close_time' => '22:00:00',
            'is_bookable' => true,
            'max_capacity' => 4,
            'booking_fee' => 50000
        ]);

        // 11. Create Announcements
        \App\Models\Announcement::create([
            'title' => 'Pemeliharaan Jaringan Listrik',
            'content' => 'Akan ada pemadaman listrik sementara besok jam 10:00 - 14:00 untuk perbaikan gardu utama.',
            'priority' => 'high',
            'created_by' => $superAdmin->id,
            'estate_id' => $estate1->id,
            'is_active' => true
        ]);

        \App\Models\Announcement::create([
            'title' => 'Selamat Datang di Raanyverse Property',
            'content' => 'Selamat datang di sistem manajemen properti terbaru kami. Nikmati fitur booking fasilitas dan pembayaran online!',
            'priority' => 'normal',
            'created_by' => $superAdmin->id,
            'estate_id' => null, // Global
            'is_active' => true
        ]);

        // 12. Create Expenses
        \App\Models\Expense::create([
            'title' => 'Gaji Satpam Bulan Ini',
            'description' => 'Pembayaran gaji untuk 3 orang security shift malam.',
            'amount' => 9000000,
            'expense_date' => Carbon::now()->subDays(2),
            'category' => 'salary',
            'recorded_by' => $superAdmin->id,
            'estate_id' => $estate1->id
        ]);

        \App\Models\Expense::create([
            'title' => 'Perbaikan Pompa Air',
            'description' => 'Penggantian dinamo pompa air utama di Ruko Grand Boulevard.',
            'amount' => 1500000,
            'expense_date' => Carbon::now()->subDays(10),
            'category' => 'maintenance',
            'recorded_by' => $superAdmin->id,
            'estate_id' => $estate1->id
        ]);

        // 13. Create Leads (CRM)
        \App\Models\Lead::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@gmail.com',
            'phone' => '081234567890',
            'interested_unit_id' => $unit1->id,
            'status' => 'survey',
            'survey_date' => Carbon::now()->addDays(2),
            'notes' => 'Tertarik sewa ruko untuk usaha minimarket.'
        ]);

        \App\Models\Lead::create([
            'name' => 'Siti Aminah',
            'email' => 'siti.aminah@yahoo.com',
            'phone' => '089876543210',
            'interested_unit_id' => $unit2->id,
            'status' => 'negotiation',
            'survey_date' => Carbon::now()->subDays(3),
            'notes' => 'Tinggal mencocokkan harga sewa tahunan.'
        ]);

        // 14. Create Visitors
        \App\Models\Visitor::create([
            'name' => 'Andi Wijaya',
            'phone' => '085211112222',
            'vehicle_number' => 'B 4123 CD',
            'unit_id' => $unit1->id,
            'purpose' => 'Servis AC berkala',
            'status' => 'inside',
            'check_in_at' => Carbon::now()->subMinutes(30)
        ]);

        // 15. Create Parcels
        \App\Models\Parcel::create([
            'recipient_name' => 'Ahmad',
            'unit_id' => $unit1->id,
            'courier_name' => 'J&T Express',
            'tracking_number' => 'JT981247192',
            'status' => 'received',
            'received_at' => Carbon::now()->subHours(2)
        ]);

    }
}
