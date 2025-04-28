<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        //  Dev user
        $us = User::create(
            [
                'name' => 'Dev admin',
                'email' => 'admin@dev.com',
                'password' => bcrypt('Nightmare98'),
                'type' => 'Administrador',
                'customer' => 'mayorista',
                'address' => 'San Pedro Sula, Honduras',
                'telephone' => '97992867',
                'image' => 'Perfil (0).jpg'
            ]
        );

        $us->assignRole('Developer');

        // Admin user
        $us = User::create(
            [
                'name' => 'Administrador',
                'email' => 'admin@admin.com',
                'password' => bcrypt('Admin2024@'),
                'type' => 'Administrador',
                'customer' => 'mayorista',
                'address' => 'San Pedro Sula, Honduras',
                'telephone' => '98000000',
                'image' => 'Perfil (1).jpg'
            ]
        );

        $us->assignRole('Administrador');

        $us = User::create(
            [
                'name' => 'Vendedor',
                'email' => 'vendedor@example.com',
                'password' => bcrypt('Vendedor2024'),
                'type' => 'Empleado',
                'customer' => 'mayorista',
                'address' => 'San Pedro Sula, Honduras',
                'telephone' => '89001122',
                'image' => 'Perfil (1).jpg'
            ]
        );

        $us->assignRole('Empleado');
    }
}
