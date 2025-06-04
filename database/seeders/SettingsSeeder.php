<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'system_name' => 'Sistema de Prueba',
            'system_version' => 'v1.0.4',
            'system_logo' => 'system_logo.png',
            'system_favicon' => 'favicon.ico',
            'system_logo_report' => 'system_logo_report.png',
            'bg_login' => 'bg_login_default.webp',
            'company_name' => 'Your Company Name',
            'company_address' => '1234 Your Address, City, State, Zip',
            'company_short_address' => '1234 Your Address',
            'company_cai' => '36C233-C71D88-3DF4E0-63BE03-0909B6-BC',
            'company_rtn' => '08011999999929',
            'company_phone' => '98282811',
            'company_email' => 'test@dev.com',
        ]);
    }
}
