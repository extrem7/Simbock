<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = ['name', 'code'];

    public const BASIC = 'BASIC';
    public const INTERMEDIATE = 'INTERMEDIATE';
    public const FLUENT = 'FLUENT';

    public static $fluencies = [
        self::BASIC => 'Basic',
        self::INTERMEDIATE => 'Intermediate',
        self::FLUENT => 'Fluent'
    ];

}
