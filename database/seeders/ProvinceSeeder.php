<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use Illuminate\Support\Facades\File;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $json = File::get("public/json/provinces.json");
        $data = json_decode($json, true);

        Province::insert($data);
    }
}
