<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regency;
use Illuminate\Support\Facades\File;

class RegencySeeder extends Seeder
{
    public function run()
    {
        $json = File::get("public/json/regencies.json");
        $data = json_decode($json, true);

        Regency::insert($data);
    }
}
