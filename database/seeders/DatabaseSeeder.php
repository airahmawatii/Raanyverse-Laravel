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
use App\Models\Region;
use App\Models\Estate;
use App\Models\Facility;
use App\Models\FacilityBooking;
use App\Models\Announcement;
use App\Models\Expense;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks for clean seeding
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        User::truncate();
        Unit::truncate();
        Booking::truncate();
        Rental::truncate();
        Billing::truncate();
        Complaint::truncate();
        Maintenance::truncate();
        Activity::truncate();
        Region::truncate();
        Estate::truncate();
        Facility::truncate();
        FacilityBooking::truncate();
        Announcement::truncate();
        Expense::truncate();
        Lead::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Create Admins & Owners
        $admin = User::create([
            'name' => 'Admin RaanyProp',
            'email' => 'admin@properti.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
            'phone' => '081234567890',
        ]);

        $owner = User::create([
            'name' => 'Owner RaanyVerse',
            'email' => 'owner@properti.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'status' => 'approved',
            'phone' => '081298765432',
        ]);

        // 2. Create Test Tenant (so the user can always log in and test with this)
        $testTenant = User::create([
            'name' => 'Yulianiyahya Tenant',
            'email' => 'tenant@properti.com',
            'password' => Hash::make('password'),
            'role' => 'tenant',
            'status' => 'approved',
            'phone' => '089988776655',
        ]);

        // 3. Create 100 Tenants (realistic Indonesian Names)
        $firstNames = [
            'Budi', 'Andi', 'Siti', 'Dewi', 'Joko', 'Bambang', 'Slamet', 'Ani', 'Hendra', 'Agus',
            'Rian', 'Dian', 'Eko', 'Heri', 'Ade', 'Wahyu', 'Rudi', 'Dedi', 'Yanto', 'Iwan',
            'Fajar', 'Arif', 'Rahmat', 'Taufik', 'Hasan', 'Agung', 'Indra', 'Putra', 'Aditya', 'Reza',
            'Dimas', 'Angga', 'Bagas', 'Gilang', 'Rangga', 'Adit', 'Rian', 'Dwi', 'Sri', 'Mega',
            'Yuni', 'Wati', 'Kartika', 'Ningsih', 'Fitri', 'Sari', 'Putri', 'Ayu', 'Eka', 'Lestari',
            'Ratna', 'Desi', 'Rina', 'Indah', 'Lisa', 'Maya', 'Novi', 'Dewi', 'Gita', 'Aulia'
        ];

        $lastNames = [
            'Santoso', 'Aminah', 'Sutrisno', 'Lestari', 'Pratama', 'Hidayat', 'Kurniawan', 'Wijaya', 'Saputra', 'Putri',
            'Sari', 'Wulandari', 'Susanto', 'Gunawan', 'Setiawan', 'Budiman', 'Nugroho', 'Prasetyo', 'Ramadhan', 'Siregar',
            'Harahap', 'Ginting', 'Sembiring', 'Pane', 'Tanjung', 'Lubis', 'Nasution', 'Simanjuntak', 'Pangaribuan', 'Sihombing',
            'Sinaga', 'Manurung', 'Sitompul', 'Nainggolan', 'Nababan', 'Hutapea', 'Tobing', 'Pasaribu', 'Hasibuan', 'Pulungan'
        ];

        $tenants = [$testTenant];
        for ($i = 0; $i < 100; $i++) {
            $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
            $email = strtolower(str_replace(' ', '.', $name)) . $i . '@properti.com';
            $tenants[] = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'tenant',
                'status' => 'approved',
                'phone' => '08' . rand(100000000, 999999999),
            ]);
        }

        // 4. Create Regions
        $regionsList = ['Jabodetabek', 'Bandung Raya', 'Surabaya Raya', 'Yogyakarta', 'Bali', 'Medan Metropolitan'];
        $regions = [];
        foreach ($regionsList as $regName) {
            $regions[] = Region::create(['name' => $regName]);
        }

        // 5. Create Estates
        $estatesList = [
            ['BSD City', 'Jl. BSD Grand Boulevard, Tangerang', 0, 'Kawasan hunian & bisnis modern mandiri di barat Jakarta.'],
            ['Grand Galaxy City', 'Jl. Boulevard Raya, Bekasi', 0, 'Kawasan hunian premium terpadu di Bekasi Selatan.'],
            ['PIK 2', 'Jl. Pantai Indah Kapuk, Jakarta Utara', 0, 'Kota mandiri baru di tepi pantai dengan fasilitas megah.'],
            ['Kota Baru Parahyangan', 'Padalarang, Bandung Barat', 1, 'Kota mandiri berwawasan lingkungan dan pendidikan.'],
            ['Dago Village', 'Jl. Dago Pakar, Bandung', 1, 'Resort hunian eksklusif di perbukitan Dago yang asri.'],
            ['CitraLand Surabaya', 'Jl. CitraLand Utama, Surabaya', 2, 'The Singapore of Surabaya, perumahan elit kelas dunia.'],
            ['Jogja Townhouse', 'Jl. Kaliurang KM 7, Yogyakarta', 3, 'Hunian klaster modern dekat kawasan kampus ternama.'],
            ['Bali Cliff Resort', 'Uluwatu, Badung, Bali', 4, 'Resort dan villa mewah di tebing karang selatan Bali.'],
            ['Medan Metropolitan', 'Jl. Ring Road, Medan', 5, 'Kawasan residensial strategis di pusat kota Medan.'],
        ];

        $estates = [];
        foreach ($estatesList as $est) {
            $estates[] = Estate::create([
                'region_id' => $regions[$est[2]]->id,
                'name' => $est[0],
                'address' => $est[1],
                'description' => $est[3],
            ]);
        }

        // 6. Create 100 Units (Properties)
        $unitTypes = ['standar', 'deluxe', 'premium', 'vip'];
        $propertyTypes = ['Rumah', 'Ruko', 'Apartemen', 'Kost'];
        $statuses = ['available', 'occupied', 'maintenance'];

        // Curated Unsplash images for beautiful visual displays
        $unsplashImages = [
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=600&q=80',
            'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=600&q=80',
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=600&q=80',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=600&q=80',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=80',
            'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80',
            'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&q=80',
            'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80',
            'https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=600&q=80',
            'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=600&q=80',
            'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=600&q=80',
            'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600&q=80'
        ];

        $units = [];
        $blocks = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        // Always make sure there is at least one unit assigned to the test tenant for a smooth login demo experience
        $unitTestTenant = Unit::create([
            'estate_id' => $estates[0]->id,
            'name' => 'Cluster Lavender Blok A-1',
            'blok' => 'A',
            'nomor_unit' => '1',
            'type' => 'premium',
            'property_type' => 'Rumah',
            'price' => 5000000,
            'status' => 'occupied',
            'image' => $unsplashImages[0]
        ]);
        $units[] = $unitTestTenant;

        for ($i = 2; $i <= 100; $i++) {
            $pType = $propertyTypes[array_rand($propertyTypes)];
            $uType = $unitTypes[array_rand($unitTypes)];
            $estate = $estates[array_rand($estates)];
            
            // Realistic prices based on property types (monthly / purchase equivalent)
            if ($pType === 'Rumah') {
                $price = rand(4000000, 15000000);
            } elseif ($pType === 'Ruko') {
                $price = rand(8000000, 25000000);
            } elseif ($pType === 'Apartemen') {
                $price = rand(3500000, 12000000);
            } else { // Kost
                $price = rand(1500000, 4000000);
            }

            $blk = $blocks[array_rand($blocks)];
            $no = rand(1, 40);

            $units[] = Unit::create([
                'estate_id' => $estate->id,
                'name' => $pType . ' ' . $uType . ' ' . $blk . '-' . $no,
                'blok' => $blk,
                'nomor_unit' => (string)$no,
                'type' => $uType,
                'property_type' => $pType,
                'price' => $price,
                'status' => $statuses[array_rand($statuses)],
                'image' => $unsplashImages[array_rand($unsplashImages)]
            ]);
        }

        // 7. Create Rentals (Occupancies)
        // Ensure test tenant has a rental record
        Rental::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $unitTestTenant->id,
            'start_date' => Carbon::now()->subMonths(6),
            'end_date' => Carbon::now()->addMonths(6),
        ]);

        // Create rentals for occupied units
        $tenantIndex = 1; // start from first dynamic tenant
        foreach ($units as $unit) {
            if ($unit->status === 'occupied' && $unit->id !== $unitTestTenant->id) {
                $tenant = $tenants[$tenantIndex] ?? $testTenant;
                Rental::create([
                    'tenant_id' => $tenant->id,
                    'unit_id' => $unit->id,
                    'start_date' => Carbon::now()->subDays(rand(10, 200)),
                    'end_date' => Carbon::now()->addDays(rand(30, 300)),
                ]);
                $tenantIndex++;
            }
        }

        // 8. Create 100 Bookings (Pesanan)
        $bookingStatuses = ['pending', 'approved', 'rejected'];
        $paymentTypes = ['sewa', 'cicilan'];
        
        // Ensure test tenant has at least 3 bookings for testing (one of each status)
        Booking::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $units[1]->id,
            'start_date' => Carbon::now()->addDays(5),
            'end_date' => Carbon::now()->addDays(5)->addMonths(3),
            'status' => 'pending',
            'payment_type' => 'sewa',
            'duration_months' => 3,
            'dp_amount' => $units[1]->price,
            'due_day' => 5
        ]);

        Booking::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $units[2]->id,
            'start_date' => Carbon::now()->subDays(20),
            'end_date' => Carbon::now()->subDays(20)->addMonths(6),
            'status' => 'approved',
            'payment_type' => 'sewa',
            'duration_months' => 6,
            'dp_amount' => $units[2]->price * 2,
            'due_day' => 10
        ]);

        Booking::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $units[3]->id,
            'start_date' => Carbon::now()->addDays(30),
            'end_date' => Carbon::now()->addDays(30)->addMonths(12),
            'status' => 'rejected',
            'payment_type' => 'cicilan',
            'duration_months' => 12,
            'dp_amount' => $units[3]->price * 3,
            'due_day' => 15
        ]);

        for ($i = 4; $i <= 100; $i++) {
            $tenant = $tenants[array_rand($tenants)];
            $unit = $units[array_rand($units)];
            $status = $bookingStatuses[array_rand($bookingStatuses)];
            $pType = $paymentTypes[array_rand($paymentTypes)];
            $duration = rand(1, 12);
            $startDate = Carbon::now()->addDays(rand(-30, 30));
            $endDate = (clone $startDate)->addMonths($duration);

            Booking::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $unit->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'payment_type' => $pType,
                'duration_months' => $duration,
                'dp_amount' => $unit->price * rand(1, 2),
                'due_day' => rand(1, 28)
            ]);
        }

        // 9. Create 100 Billings (Tagihan)
        $billingStatuses = ['unpaid', 'paid', 'overdue'];
        
        // Ensure test tenant has at least 3 billings (one of each status)
        Billing::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $unitTestTenant->id,
            'amount' => $unitTestTenant->price,
            'period' => Carbon::now()->format('F Y'),
            'status' => 'unpaid',
            'admin_fee' => 10000,
            'platform_fee' => 2500,
            'paid_amount' => 0,
            'due_date' => Carbon::now()->addDays(10)
        ]);

        Billing::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $unitTestTenant->id,
            'amount' => $unitTestTenant->price,
            'period' => Carbon::now()->subMonth()->format('F Y'),
            'status' => 'paid',
            'admin_fee' => 10000,
            'platform_fee' => 2500,
            'paid_amount' => $unitTestTenant->price + 12500,
            'due_date' => Carbon::now()->subMonth()
        ]);

        Billing::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $unitTestTenant->id,
            'amount' => $unitTestTenant->price,
            'period' => Carbon::now()->subMonths(2)->format('F Y'),
            'status' => 'overdue',
            'admin_fee' => 10000,
            'platform_fee' => 2500,
            'fine_amount' => 50000,
            'paid_amount' => 0,
            'due_date' => Carbon::now()->subMonths(2)->addDays(5)
        ]);

        for ($i = 4; $i <= 100; $i++) {
            $tenant = $tenants[array_rand($tenants)];
            // Get tenant's unit if they have a rental, otherwise pick a random one
            $rental = Rental::where('tenant_id', $tenant->id)->first();
            $unit = $rental ? Unit::find($rental->unit_id) : $units[array_rand($units)];
            
            $status = $billingStatuses[array_rand($billingStatuses)];
            $amount = $unit->price;
            $period = Carbon::now()->subMonths(rand(0, 5))->format('F Y');
            $dueDate = Carbon::now()->addDays(rand(-60, 30));

            $adminFee = 10000;
            $platformFee = 2500;
            $fineAmount = ($status === 'overdue') ? 50000 : 0;
            $paidAmount = ($status === 'paid') ? ($amount + $adminFee + $platformFee) : 0;

            Billing::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $unit->id,
                'amount' => $amount,
                'period' => $period,
                'status' => $status,
                'admin_fee' => $adminFee,
                'platform_fee' => $platformFee,
                'fine_amount' => $fineAmount,
                'paid_amount' => $paidAmount,
                'due_date' => $dueDate
            ]);
        }

        // 10. Create 100 Complaints (Keluhan)
        $complaintCategories = ['kebersihan', 'keamanan', 'fasilitas', 'listrik', 'bangunan', 'lainnya'];
        $complaintTitles = [
            'kebersihan' => ['Sampah Menumpuk di Koridor', 'Area Parkir Sangat Kotor', 'Bau Tidak Sedap dari Saluran Air'],
            'keamanan' => ['Lampu Koridor Padam Total', 'Pintu Gerbang Rusak/Tidak Terkunci', 'Orang Asing Mencurigakan Berkeliaran'],
            'fasilitas' => ['Alat Gym Rusak Parah', 'Kolam Renang Keruh Hijau', 'Lift Sering Macet & Berbunyi'],
            'listrik' => ['Listrik Sering Turun/Jepret', 'Tagihan Air Tidak Wajar', 'Kran Air Kamar Mandi Bocor'],
            'bangunan' => ['Atap Kamar Mandi Kebocoran', 'Tembok Retak Rambut Parah', 'Pintu Utama Sulit Dikunci'],
            'lainnya' => ['Tetangga Sangat Bising Malam Hari', 'Parkir Sembarangan Menghalangi Jalan', 'Hewan Liar Masuk Area Hunian']
        ];
        $priorities = ['rendah', 'sedang', 'tinggi'];

        // Ensure test tenant has some complaints
        Complaint::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $unitTestTenant->id,
            'description' => "### KELUHAN ###\nJudul: Kran Air Bocor\nKategori: listrik\nPrioritas: sedang\nLokasi: Dapur\nDeskripsi: Kran air di tempat cuci piring bocor terus menerus meskipun sudah diputar kencang.",
            'status' => 'pending'
        ]);

        Complaint::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $unitTestTenant->id,
            'description' => "### KELUHAN ###\nJudul: Atap Bocor Saat Hujan\nKategori: bangunan\nPrioritas: tinggi\nLokasi: Kamar Utama\nDeskripsi: Saat hujan deras semalam, air merembes dari plafon kamar tidur utama cukup deras.",
            'status' => 'resolved'
        ]);

        for ($i = 3; $i <= 100; $i++) {
            $tenant = $tenants[array_rand($tenants)];
            $rental = Rental::where('tenant_id', $tenant->id)->first();
            $unit = $rental ? Unit::find($rental->unit_id) : $units[array_rand($units)];
            
            $cat = $complaintCategories[array_rand($complaintCategories)];
            $titleList = $complaintTitles[$cat];
            $title = $titleList[array_rand($titleList)];
            $prio = $priorities[array_rand($priorities)];
            
            $status = rand(0, 1) ? 'resolved' : 'pending';
            
            $desc = "### KELUHAN ###\nJudul: {$title}\nKategori: {$cat}\nPrioritas: {$prio}\nLokasi: Area Unit\nDeskripsi: Ditemukan keluhan mengenai {$title}. Mohon ditindaklanjuti segera demi kenyamanan bersama.";
            
            Complaint::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $unit->id,
                'description' => $desc,
                'status' => $status
            ]);
        }

        // 11. Create 100 Maintenances (Perbaikan)
        $maintenanceTypes = ['plumbing', 'listrik', 'ac', 'pintu', 'lantai', 'atap', 'furniture', 'lainnya'];
        $maintenanceTitles = [
            'plumbing' => 'Pipa Air Utama Bocor',
            'listrik' => 'Stop Kontak Kamar Mati',
            'ac' => 'AC Kurang Dingin & Netes Air',
            'pintu' => 'Engsel Pintu Kamar Mandi Lepas',
            'lantai' => 'Keramik Lantai Retak/Pecah',
            'atap' => 'Plafon Kamar Lembab & Rapuh',
            'furniture' => 'Lemari Pakaian Pintu Geser Macet',
            'lainnya' => 'Cat Tembok Mengelupas'
        ];

        // Ensure test tenant has some maintenance requests
        Maintenance::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $unitTestTenant->id,
            'description' => "### PERBAIKAN ###\nJudul: AC Tidak Dingin\nJenis: AC & Ventilasi\nUrgensi: sedang\nJadwal: " . Carbon::now()->addDays(2)->format('Y-m-d') . "\nLokasi: Kamar Depan\nDeskripsi: AC hanya mengeluarkan angin saja, tidak dingin sama sekali.",
            'status' => 'pending'
        ]);

        Maintenance::create([
            'tenant_id' => $testTenant->id,
            'unit_id' => $unitTestTenant->id,
            'description' => "### PERBAIKAN ###\nJudul: Perbaikan Saklar Lampu\nJenis: Instalasi Listrik\nUrgensi: rendah\nJadwal: " . Carbon::now()->subDays(5)->format('Y-m-d') . "\nLokasi: Ruang Tamu\nDeskripsi: Saklar lampu utama ruang tamu longgar dan kadang tidak tersambung.",
            'status' => 'resolved'
        ]);

        for ($i = 3; $i <= 100; $i++) {
            $tenant = $tenants[array_rand($tenants)];
            $rental = Rental::where('tenant_id', $tenant->id)->first();
            $unit = $rental ? Unit::find($rental->unit_id) : $units[array_rand($units)];
            
            $type = $maintenanceTypes[array_rand($maintenanceTypes)];
            $title = $maintenanceTitles[$type];
            $urg = $priorities[array_rand($priorities)];
            $status = rand(0, 1) ? 'resolved' : 'pending';
            $schedDate = Carbon::now()->addDays(rand(-10, 10))->format('Y-m-d');
            
            $desc = "### PERBAIKAN ###\nJudul: {$title}\nJenis: {$type}\nUrgensi: {$urg}\nJadwal: {$schedDate}\nLokasi: Unit Utama\nDeskripsi: Mengajukan permintaan perbaikan berupa {$title} yang terdeteksi bermasalah.";

            Maintenance::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $unit->id,
                'description' => $desc,
                'status' => $status
            ]);
        }

        // 12. Create 100 Activities (Aktivitas Terbaru)
        $modules = ['booking', 'complaint', 'maintenance', 'payment', 'billing'];
        $actions = [
            'booking' => ['Booking Created', 'Booking Cancelled', 'Booking Approved'],
            'complaint' => ['Complaint Created', 'Complaint Resolved'],
            'maintenance' => ['Maintenance Request Created', 'Maintenance Resolved'],
            'payment' => ['Payment Simulation Completed', 'Payment Verified'],
            'billing' => ['Bill Generated', 'Bill Marked Overdue']
        ];

        // Ensure test tenant has activities
        Activity::create([
            'user_id' => $testTenant->id,
            'action' => 'Bill Paid',
            'module' => 'payment',
            'description' => 'Membayar tagihan sewa bulanan untuk unit ' . $unitTestTenant->name,
            'ip_address' => '127.0.0.1'
        ]);

        Activity::create([
            'user_id' => $testTenant->id,
            'action' => 'Complaint Created',
            'module' => 'complaint',
            'description' => 'Mengirim keluhan Kran Air Bocor di Dapur',
            'ip_address' => '127.0.0.1'
        ]);

        for ($i = 3; $i <= 100; $i++) {
            $tenant = $tenants[array_rand($tenants)];
            $mod = $modules[array_rand($modules)];
            $actList = $actions[$mod];
            $act = $actList[array_rand($actList)];
            
            Activity::create([
                'user_id' => $tenant->id,
                'action' => $act,
                'module' => $mod,
                'description' => "Melakukan aktivitas {$act} pada modul {$mod} di sistem.",
                'ip_address' => '192.168.1.' . rand(2, 254)
            ]);
        }

        // 13. Create Facilities
        $facilities = [
            ['Kolam Renang Executive', 'Kolam renang ukuran olimpiade dengan area berjemur santai.', '06:00:00', '21:00:00', 30, 0],
            ['Pusat Kebugaran / Gym', 'Fasilitas gym lengkap dengan peralatan kardio dan beban modern.', '06:00:00', '22:00:00', 15, 0],
            ['Lapangan Tenis Outdoor', 'Dua lapangan tenis outdoor berstandar internasional dengan pencahayaan malam.', '06:00:00', '22:00:00', 4, 25000],
            ['Co-Working Space', 'Ruang kerja bersama dengan internet super cepat, AC dingin, dan teh/kopi gratis.', '08:00:00', '20:00:00', 25, 10000],
            ['Barbeque Pavilion', 'Area taman terbuka lengkap dengan panggangan gas dan meja makan outdoor.', '16:00:00', '23:00:00', 12, 50000],
            ['Bioskop Mini / Mini Cinema', 'Studio bioskop eksklusif dengan 10 sofa malas dan sound system Dolby Atmos.', '10:00:00', '23:59:00', 10, 100000],
        ];

        $facilityModels = [];
        foreach ($facilities as $fac) {
            $facilityModels[] = Facility::create([
                'estate_id' => $estates[array_rand($estates)]->id,
                'name' => $fac[0],
                'description' => $fac[1],
                'open_time' => $fac[2],
                'close_time' => $fac[3],
                'is_bookable' => true,
                'max_capacity' => $fac[4],
                'booking_fee' => $fac[5]
            ]);
        }

        // 14. Create Facility Bookings
        for ($i = 1; $i <= 50; $i++) {
            $tenant = $tenants[array_rand($tenants)];
            $fac = $facilityModels[array_rand($facilityModels)];
            $date = Carbon::now()->addDays(rand(-5, 15))->format('Y-m-d');
            $shour = rand(8, 18);
            $ehour = $shour + rand(1, 3);
            
            FacilityBooking::create([
                'facility_id' => $fac->id,
                'tenant_id' => $tenant->id,
                'booking_date' => $date,
                'start_time' => sprintf('%02d:00', $shour),
                'end_time' => sprintf('%02d:00', $ehour),
                'guest_count' => rand(1, min($fac->max_capacity, 5)),
                'status' => rand(0, 3) === 0 ? 'pending' : 'approved'
            ]);
        }

        // 15. Create Announcements
        $announcementTemplates = [
            ['Pemadaman Listrik Sementara', 'Akan dilakukan perawatan gardu listrik utama oleh PLN besok mulai jam 09:00 hingga 12:00 WIB. Mohon persiapkan perangkat Anda.', 'high'],
            ['Fogging Demam Berdarah', 'Untuk mencegah penyebaran nyamuk DBD, tim kebersihan akan melakukan fogging di seluruh area klaster pada hari Sabtu pagi jam 07:00 WIB. Mohon tutup pintu dan jendela rapat-rapat.', 'normal'],
            ['Sistem Pembayaran Manual Baru', 'Kami mengimbau kepada seluruh penyewa bahwa pembayaran tagihan kini dikonfirmasikan secara langsung ke WhatsApp Admin demi keamanan dan kemudahan pencatatan kuitansi digital.', 'high'],
            ['Kerja Bakti Lingkungan', 'Mengundang seluruh warga untuk ikut serta dalam kegiatan kerja bakti membersihkan saluran air dan taman bersama pada hari Minggu mulai jam 07:30 WIB di depan Clubhouse.', 'normal'],
            ['Layanan Pengaduan Digital', 'Layanan pengaduan kini sepenuhnya terintegrasi dalam aplikasi RaanyProp. Anda dapat mengunggah foto keluhan dan memantau progress perbaikan secara real-time.', 'normal']
        ];

        for ($i = 1; $i <= 30; $i++) {
            $tpl = $announcementTemplates[array_rand($announcementTemplates)];
            Announcement::create([
                'title' => $tpl[0] . ' #' . $i,
                'content' => $tpl[1],
                'priority' => $tpl[2],
                'created_by' => $admin->id,
                'estate_id' => rand(0, 2) === 0 ? null : $estates[array_rand($estates)]->id,
                'is_active' => true
            ]);
        }

        // 16. Create Expenses (Pengeluaran Operasional)
        $expenseCategories = ['salary', 'maintenance', 'utilities', 'cleaning', 'security', 'other'];
        $expenseTitles = [
            'salary' => 'Pembayaran Gaji Staff Kebersihan',
            'maintenance' => 'Perbaikan Kebocoran Pipa Air Cluster',
            'utilities' => 'Pembayaran Tagihan Listrik Fasilitas Umum',
            'cleaning' => 'Pembelian Alat-alat Kebersihan Bulanan',
            'security' => 'Pengadaan Seragam Security Baru',
            'other' => 'Konsumsi Rapat Pengelola Properti'
        ];

        for ($i = 1; $i <= 50; $i++) {
            $cat = $expenseCategories[array_rand($expenseCategories)];
            $title = $expenseTitles[$cat];
            
            Expense::create([
                'title' => $title . ' - Ops ' . $i,
                'description' => 'Biaya operasional untuk menunjang aktivitas pengelolaan properti.',
                'amount' => rand(500000, 15000000),
                'expense_date' => Carbon::now()->subDays(rand(1, 90)),
                'category' => $cat,
                'recorded_by' => $admin->id,
                'estate_id' => $estates[array_rand($estates)]->id
            ]);
        }

        // 17. Create Leads (CRM Prospek Pembeli/Penyewa)
        $leadStatuses = ['new', 'contact', 'survey', 'negotiation', 'closed'];
        for ($i = 1; $i <= 50; $i++) {
            $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
            $email = strtolower(str_replace(' ', '.', $name)) . $i . '@gmail.com';
            
            Lead::create([
                'name' => $name,
                'email' => $email,
                'phone' => '08' . rand(100000000, 999999999),
                'interested_unit_id' => $units[array_rand($units)]->id,
                'status' => $leadStatuses[array_rand($leadStatuses)],
                'survey_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 10)) : null,
                'notes' => 'Prospek penyewa baru tertarik melihat unit hunian tipe deluxe.'
            ]);
        }
    }
}
