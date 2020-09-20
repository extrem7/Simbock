<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = ['user_id'];

    protected $fillable = [
        'title', 'sector_id', 'description', 'size_id',
        'address', 'address_2', 'city_id', 'state_id', 'zip',
        'phone', 'email', 'social'
    ];
}
