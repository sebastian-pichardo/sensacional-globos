<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GloboModa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'globos_moda';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'color',
        'ruta_img',
        'activo', # si/no 
    ];
}
