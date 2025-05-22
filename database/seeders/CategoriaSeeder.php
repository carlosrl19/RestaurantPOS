<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;


class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            'DESAYUNO',
            'ALMUERZO',
            'CENA',
            'POSTRE',
            'BEBIDAS GASEOSAS',
            'BEBIDAS ALCOHOLICAS',
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(['category_name' => $nombre]);
        }
    }
}
