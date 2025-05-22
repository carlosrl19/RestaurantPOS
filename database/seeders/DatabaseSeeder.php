<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;



class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(ProveedorTableSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(SettingsSeeder::class);
    }
}
