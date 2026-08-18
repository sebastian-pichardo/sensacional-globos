<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogDownload extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'ip',
        'user_agent',
    ];
}
