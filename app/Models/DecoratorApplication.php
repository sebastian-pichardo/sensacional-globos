<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DecoratorApplication extends Model
{
    protected $fillable = [
        'name',
        'whatsapp',
        'email',
        'motivation',
        'social_networks',
        'city_or_state',
        'accept_promotions',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'accept_promotions' => 'boolean',
        ];
    }
}
