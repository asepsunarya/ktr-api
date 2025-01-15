<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
use Illuminate\Support\Facades\File;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        $json = File::get("public/json/districts.json");
        $data = json_decode($json, true);

        District::insert($data);
    }
}
