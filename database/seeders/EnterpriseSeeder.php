<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Estate;
use App\Models\Unit;

class EnterpriseSeeder extends Seeder
{
    public function run()
    {
        $region = Region::create([
            'name' => 'Kawasan Summarecon Serpong'
        ]);

        $estate = Estate::create([
            'region_id' => $region->id,
            'name' => 'Cluster Symphonia Lake',
            'description' => 'Cluster Mewah dengan Pemandangan Danau'
        ]);

        // Rumah 1
        Unit::create([
            'estate_id' => $estate->id,
            'name' => 'Blok A1 No. 8',
            'blok' => 'A1',
            'nomor_unit' => '8',
            'type' => 'Tipe 120/80',
            'property_type' => 'rumah',
            'price' => 75000000,
            'status' => 'available'
        ]);

        // Rumah 2 (dengan Nama Khusus)
        Unit::create([
            'estate_id' => $estate->id,
            'name' => 'Rumah Fasad Eropa',
            'blok' => 'A1',
            'nomor_unit' => '9',
            'type' => 'Tipe 120/80',
            'property_type' => 'rumah',
            'price' => 77000000,
            'status' => 'available'
        ]);

        // Rumah 3
        Unit::create([
            'estate_id' => $estate->id,
            'name' => 'Blok B3 No. 1',
            'blok' => 'B3',
            'nomor_unit' => '1',
            'type' => 'Tipe 150/100',
            'property_type' => 'rumah',
            'price' => 95000000,
            'status' => 'available'
        ]);
        
        // Ruko 
        $estateRuko = Estate::create([
            'region_id' => $region->id,
            'name' => 'Ruko Sentra Niaga',
            'description' => 'Kawasan Komersial Strategis'
        ]);

        Unit::create([
            'estate_id' => $estateRuko->id,
            'name' => 'Blok Boulevard No. 12',
            'blok' => 'Boulevard',
            'nomor_unit' => '12',
            'type' => 'Ruko 3 Lantai',
            'property_type' => 'ruko',
            'price' => 95000000,
            'status' => 'available'
        ]);
    }
}
