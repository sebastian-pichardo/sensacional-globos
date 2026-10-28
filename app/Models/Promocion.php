<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends Model
{
    use SoftDeletes;

    protected $table = 'promociones';
    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'participante',
        'lugar'
    ];
}
