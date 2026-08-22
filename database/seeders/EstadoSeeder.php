<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['clave' => '01', 'nombre' => 'Aguascalientes', 'abrev' => 'Ags.', 'activo' => 1, 'clave_sat' => 'AGU'],
            ['clave' => '02', 'nombre' => 'Baja California', 'abrev' => 'BC',     'activo' => 1, 'clave_sat' => 'BCN'],
            ['clave' => '03', 'nombre' => 'Baja California Sur', 'abrev' => 'BCS',    'activo' => 1, 'clave_sat' => 'BCS'],
            ['clave' => '04', 'nombre' => 'Campeche', 'abrev' => 'Camp.',  'activo' => 1, 'clave_sat' => 'CAM'],
            ['clave' => '05', 'nombre' => 'Coahuila de Zaragoza', 'abrev' => 'Coah.',  'activo' => 1, 'clave_sat' => 'COA'],
            ['clave' => '06', 'nombre' => 'Colima',  'abrev' => 'Col.',   'activo' => 1, 'clave_sat' => 'COL'],
            ['clave' => '07', 'nombre' => 'Chiapas',                         'abrev' => 'Chis.',  'activo' => 1, 'clave_sat' => 'CHP'],
            ['clave' => '08', 'nombre' => 'Chihuahua',                       'abrev' => 'Chih.',  'activo' => 1, 'clave_sat' => 'CHH'],
            ['clave' => '09', 'nombre' => 'Ciudad de México',                'abrev' => 'CDMX',   'activo' => 1, 'clave_sat' => 'CMX'],
            ['clave' => '10', 'nombre' => 'Durango',                         'abrev' => 'Dgo.',   'activo' => 1, 'clave_sat' => 'DUR'],
            ['clave' => '11', 'nombre' => 'Guanajuato',                      'abrev' => 'Gto.',   'activo' => 1, 'clave_sat' => 'GUA'],
            ['clave' => '12', 'nombre' => 'Guerrero',                        'abrev' => 'Gro.',   'activo' => 1, 'clave_sat' => 'GRO'],
            ['clave' => '13', 'nombre' => 'Hidalgo',                         'abrev' => 'Hgo.',   'activo' => 1, 'clave_sat' => 'HID'],
            ['clave' => '14', 'nombre' => 'Jalisco',                         'abrev' => 'Jal.',   'activo' => 1, 'clave_sat' => 'JAL'],
            ['clave' => '15', 'nombre' => 'México',                          'abrev' => 'Mex.',   'activo' => 1, 'clave_sat' => 'MEX'],
            ['clave' => '16', 'nombre' => 'Michoacán de Ocampo',             'abrev' => 'Mich.',  'activo' => 1, 'clave_sat' => 'MIC'],
            ['clave' => '17', 'nombre' => 'Morelos',                         'abrev' => 'Mor.',   'activo' => 1, 'clave_sat' => 'MOR'],
            ['clave' => '18', 'nombre' => 'Nayarit',                         'abrev' => 'Nay.',   'activo' => 1, 'clave_sat' => 'NAY'],
            ['clave' => '19', 'nombre' => 'Nuevo León',                      'abrev' => 'NL',     'activo' => 1, 'clave_sat' => 'NLE'],
            ['clave' => '20', 'nombre' => 'Oaxaca',                          'abrev' => 'Oax.',   'activo' => 1, 'clave_sat' => 'OAX'],
            ['clave' => '21', 'nombre' => 'Puebla',                          'abrev' => 'Pue.',   'activo' => 1, 'clave_sat' => 'PUE'],
            ['clave' => '22', 'nombre' => 'Querétaro',                       'abrev' => 'Qro.',   'activo' => 1, 'clave_sat' => 'QUE'],
            ['clave' => '23', 'nombre' => 'Quintana Roo',                    'abrev' => 'Q. Roo', 'activo' => 1, 'clave_sat' => 'ROO'],
            ['clave' => '24', 'nombre' => 'San Luis Potosí',                 'abrev' => 'SLP',    'activo' => 1, 'clave_sat' => 'SLP'],
            ['clave' => '25', 'nombre' => 'Sinaloa',                         'abrev' => 'Sin.',   'activo' => 1, 'clave_sat' => 'SIN'],
            ['clave' => '26', 'nombre' => 'Sonora',                          'abrev' => 'Son.',   'activo' => 1, 'clave_sat' => 'SON'],
            ['clave' => '27', 'nombre' => 'Tabasco',                         'abrev' => 'Tab.',   'activo' => 1, 'clave_sat' => 'TAB'],
            ['clave' => '28', 'nombre' => 'Tamaulipas',                      'abrev' => 'Tamps.', 'activo' => 1, 'clave_sat' => 'TAM'],
            ['clave' => '29', 'nombre' => 'Tlaxcala',                        'abrev' => 'Tlax.',  'activo' => 1, 'clave_sat' => 'TLA'],
            ['clave' => '30', 'nombre' => 'Veracruz de Ignacio de la Llave', 'abrev' => 'Ver.',   'activo' => 1, 'clave_sat' => 'VER'],
            ['clave' => '31', 'nombre' => 'Yucatán',                         'abrev' => 'Yuc.',   'activo' => 1, 'clave_sat' => 'YUC'],
            ['clave' => '32', 'nombre' => 'Zacatecas',                       'abrev' => 'Zac.',   'activo' => 1, 'clave_sat' => 'ZAC'],
        ];

        foreach ($estados as $estado) {
            Estado::updateOrCreate(
                ['clave' => $estado['clave']],
                $estado
            );
        }
    }
}
