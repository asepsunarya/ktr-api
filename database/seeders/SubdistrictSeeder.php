<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\File;

class SubdistrictSeeder extends Seeder
{
    public function run()
    {
        $json = File::get("public/json/subdistricts.json");
        $data = json_decode($json, true);

        $chunks = array_chunk($data, 10000);

        foreach ($chunks as $chunk) {
            Subdistrict::insert($chunk);
        }
    }
}
