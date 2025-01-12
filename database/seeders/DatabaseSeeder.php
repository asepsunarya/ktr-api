<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Setting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123'),
        ]);

        Setting::factory()->create([
            'key' => 'cost',
            'value' => '0',
        ]);

        Setting::factory()->create([
            'key' => 'time_period',
            'value' => '10',
        ]);

        Setting::factory()->create([
            'key' => 'terms_and_conditions',
            'value' => '1. Surat Permohonan Keterangan Tata Ruang yang
ditujukan kepada Kepala Dinas Pekerjaan Umum dan
Tata Ruang Kabupaten Cianjur&nbsp;
2. Fotokopi KTP/surat identitas lainnya&nbsp;
3. Fotokopi surat tanah&nbsp;
4.Gambar situasi/letak tanah/Koordinat;&nbsp;
5.Nomor kontak pemohon.',
        ]);

        Setting::factory()->create([
            'key' => 'email',
            'value' => 'tataruang.putr@cianjurkab.go.id',
        ]);

        Setting::factory()->create([
            'key' => 'website',
            'value' => 'putr.cianjurkab.go.id',
        ]);

        Setting::factory()->create([
            'key' => 'phone',
            'value' => '6282218951892',
        ]);

        Setting::factory()->create([
            'key' => 'address',
            'value' => 'Jln. Adisucipta Nomor 2',
        ]);

        Setting::factory()->create([
            'key' => 'service_flow_title_1',
            'value' => '',
        ]);

        Setting::factory()->create([
            'key' => 'service_flow_title_2',
            'value' => '',
        ]);

        Setting::factory()->create([
            'key' => 'service_flow_title_3',
            'value' => '',
        ]);

        Setting::factory()->create([
            'key' => 'service_flow_description_1',
            'value' => '',
        ]);

        Setting::factory()->create([
            'key' => 'service_flow_description_2',
            'value' => '',
        ]);

        Setting::factory()->create([
            'key' => 'service_flow_description_3',
            'value' => '',
        ]);
    }
}
