<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $fillable = ['name', 'code'];
}
