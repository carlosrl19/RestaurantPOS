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
            'system_logo' => 'system_logo.png',
            'system_logo_report' => 'system_logo_report.png',
            'company_name' => 'Your Company Name',
            'company_address' => '1234 Your Address, City, State, Zip',
            'company_short_address' => '1234 Your Address',
            'company_cai' => '12345678901234567890123456789012',
            'company_rtn' => '08011999999929',
            'company_phone' => '98282811',
            'company_email' => 'test@dev.com',
        ]);
    }
}
