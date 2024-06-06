<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistritosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('distritos')->truncate();

        DB::table('distritos')->insert([
            ["id" => 1, "nombre" => 'BARBOSA CENTRAL'],
            ["id" => 2, "nombre" => 'BARBOSA NORTE'],
            ["id" => 3, "nombre" => 'DISTRITO ARATOCA'],
            ["id" => 4, "nombre" => 'DISTRITO BARBOSA EMANUEL'],
            ["id" => 5, "nombre" => 'DISTRITO CAMPO HERMOSO'],
            ["id" => 6, "nombre" => 'DISTRITO CANAAN NORTE'],
            ["id" => 7, "nombre" => 'DISTRITO CAPITANEJO'],
            ["id" => 8, "nombre" => 'DISTRITO CAÑAVERAL'],
            ["id" => 9, "nombre" => 'DISTRITO CENTRAL'],
            ["id" => 10, "nombre" => 'DISTRITO COAL'],
            ["id" => 11, "nombre" => 'DISTRITO COLORADOS'],
            ["id" => 12, "nombre" => 'DISTRITO DIAMANTE II'],
            ["id" => 13, "nombre" => 'DISTRITO FILADELFIA'],
            ["id" => 14, "nombre" => 'DISTRITO FLORIDABLANCA'],
            ["id" => 15, "nombre" => 'DISTRITO GUAVATA'],
            ["id" => 16, "nombre" => 'DISTRITO JARDÍN'],
            ["id" => 17, "nombre" => 'DISTRITO KENNEDY'],
            ["id" => 18, "nombre" => 'DISTRITO LA BRICHA'],
            ["id" => 19, "nombre" => 'DISTRITO LA COLINA'],
            ["id" => 20, "nombre" => 'DISTRITO LA CUMBRE'],
            ["id" => 21, "nombre" => 'DISTRITO LA VICTORIA'],
            ["id" => 91, "nombre" => 'DISTRITO MALAGA'],
            ["id" => 22, "nombre" => 'DISTRITO MIRAFLORES'],
            ["id" => 23, "nombre" => 'DISTRITO MUTIS'],
            ["id" => 24, "nombre" => 'DISTRITO NORTE'],
            ["id" => 25, "nombre" => 'DISTRITO NUEVA JERUSALEM'],
            ["id" => 26, "nombre" => 'DISTRITO PARAÍSO'],
            ["id" => 27, "nombre" => 'DISTRITO PIEDECUESTA BETANIA'],
            ["id" => 28, "nombre" => 'DISTRITO PIEDECUESTA CENTRAL'],
            ["id" => 29, "nombre" => 'DISTRITO PIEDECUESTA SANTUARIO'],
            ["id" => 30, "nombre" => 'DISTRITO PLAYÓN'],
            ["id" => 31, "nombre" => 'DISTRITO PUENTE NACIONAL'],
            ["id" => 32, "nombre" => 'DISTRITO PÁRAMO'],
            ["id" => 33, "nombre" => 'DISTRITO REDENCIÓN'],
            ["id" => 34, "nombre" => 'DISTRITO RENUEVAME'],
            ["id" => 35, "nombre" => 'DISTRITO RIONEGRO BETHEL'],
            ["id" => 36, "nombre" => 'DISTRITO RIONEGRO SHALOM'],
            ["id" => 37, "nombre" => 'DISTRITO SAN ANDRES'],
            ["id" => 38, "nombre" => 'DISTRITO SAN GIL'],
            ["id" => 39, "nombre" => 'DISTRITO SION SAN GIL'],
            ["id" => 40, "nombre" => 'DISTRITO SOCORRO'],
            ["id" => 41, "nombre" => 'DISTRITO SOTOMAYOR'],
            ["id" => 42, "nombre" => 'DISTRITO TONA'],
            ["id" => 43, "nombre" => 'DISTRITO VELEZ'],
    
   ] );
    }
}
