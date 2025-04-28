<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorTableSeeder extends Seeder
{
    public function run()
    {
        Proveedor::create(
            [
                'provider_company_name' => 'Proveedor genérico',
                'provider_company_rtn' => '00000000000000',
                'provider_company_phone' => '90000000',
                'provider_company_address' => 'San Pedro Sula, Honduras',
                'provider_contact_name' => 'Proveedor genérico',
                'provider_contact_phone' => '30000000',
            ]
        );
    }
}
