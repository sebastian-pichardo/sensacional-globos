<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class GloboEstandar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'globos_estandar';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'color',
        'ruta_img',
        'activo', # si/no 
    ];
}
