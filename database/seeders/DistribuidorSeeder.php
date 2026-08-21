<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Distribuidor;

class DistribuidorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $distribuidores = [
            [
                'nombre' => 'Juan',
                'apellido_paterno' => 'Pérez',
                'apellido_materno' => 'López',
                'clave' => 'globos26',
                'empresa' => 'Globos Alegria',
                'rfc' => null,
                'calle' => 'Av. Reforma',
                'num_exterior' => '100',
                'num_interior' => null,
                'colonia' => 'Centro',
                'estado_clave' => 'PUE',
                'codigo_postal' => '72000',
                'email' => 'juan@example.com',
                'activo' => 'si',
            ],
            [
                'nombre' => 'Alexa',
                'apellido_paterno' => 'Martinez',
                'apellido_materno' => 'Juarez',
                'clave' => 'g3juarez26',
                'empresa' => 'Martinez Papelria',
                'rfc' => 'PELJ900101ABC',
                'calle' => 'Av. 5 de Febrero',
                'num_exterior' => '500',
                'num_interior' => 'Local A',
                'colonia' => 'Zocalo de Zamora',
                'estado_clave' => 'MIC',
                'codigo_postal' => '59600',
                'email' => 'alexa@example.com',
                'activo' => 'si',
            ],
            [
                'nombre' => 'Carlos',
                'apellido_paterno' => 'Martínez',
                'apellido_materno' => 'López',
                'clave' => 'OAX-DIST-001',
                'empresa' => 'Distribuidora Oaxaca Centro',
                'rfc' => 'MALC900101ABC',
                'calle' => 'Av. Independencia',
                'num_exterior' => '120',
                'num_interior' => null,
                'colonia' => 'Centro',
                'estado_clave' => 'OAX',
                'codigo_postal' => '68000',
                'email' => 'carlos.martinez@example.com',
                'activo' => 'si',
            ],
            [
                'nombre' => 'María',
                'apellido_paterno' => 'Hernández',
                'apellido_materno' => 'García',
                'clave' => 'OAX-DIST-002',
                'empresa' => 'Comercializadora del Valle',
                'rfc' => 'HEGM920215XYZ',
                'calle' => 'Calzada Porfirio Díaz',
                'num_exterior' => '305',
                'num_interior' => '2',
                'colonia' => 'Reforma',
                'estado_clave' => 'OAX',
                'codigo_postal' => '68050',
                'email' => 'maria.hernandez@example.com',
                'activo' => 'si',
            ],
            [
                'nombre' => 'José',
                'apellido_paterno' => 'Ramírez',
                'apellido_materno' => 'Sánchez',
                'clave' => 'OAX-DIST-003',
                'empresa' => 'Suministros del Sur',
                'rfc' => 'RASJ880520DEF',
                'calle' => 'Av. Universidad',
                'num_exterior' => '850',
                'num_interior' => null,
                'colonia' => 'Ex Hacienda Candiani',
                'estado_clave' => 'OAX',
                'codigo_postal' => '68130',
                'email' => 'jose.ramirez@example.com',
                'activo' => 'si',
            ],
            [
                'nombre' => 'Ana',
                'apellido_paterno' => 'Gómez',
                'apellido_materno' => 'Torres',
                'clave' => 'OAX-DIST-004',
                'empresa' => 'Productos Oaxaqueños',
                'rfc' => 'GOTA950810GHI',
                'calle' => 'Símbolos Patrios',
                'num_exterior' => '410',
                'num_interior' => '5',
                'colonia' => 'Candiani',
                'estado_clave' => 'OAX',
                'codigo_postal' => '68130',
                'email' => 'ana.gomez@example.com',
                'activo' => 'si',
            ],
            [
                'nombre' => 'Luis',
                'apellido_paterno' => 'Cruz',
                'apellido_materno' => 'Mendoza',
                'clave' => 'OAX-DIST-005',
                'empresa' => 'Distribuciones Monte Albán',
                'rfc' => 'CUML870312JKL',
                'calle' => 'Carretera Internacional',
                'num_exterior' => '1500',
                'num_interior' => null,
                'colonia' => 'Santa Rosa',
                'estado_clave' => 'OAX',
                'codigo_postal' => '68039',
                'email' => 'luis.cruz@example.com',
                'activo' => 'si',
            ],
        ];

        foreach ($distribuidores as $distribuidor) {
            Distribuidor::updateOrCreate(
                [
                    'email' => $distribuidor['email'],
                ],
                $distribuidor
            );
        }
    }
}
