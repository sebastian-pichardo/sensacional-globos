<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientePotencial extends Model
{
    use SoftDeletes;

    protected $table = 'clientes_potenciales';

    protected $fillable = [
        'email',
        'validado',
        'medio',
    ];
}
