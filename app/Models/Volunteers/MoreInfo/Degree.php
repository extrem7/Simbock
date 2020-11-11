<?php

namespace App\Models\Volunteers\MoreInfo;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    protected $table = 'volunteer_levels_of_education';

    protected $fillable = ['name'];
}
