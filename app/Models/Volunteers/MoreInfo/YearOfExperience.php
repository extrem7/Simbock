<?php

namespace App\Models\Volunteers\MoreInfo;

use Illuminate\Database\Eloquent\Model;

class YearOfExperience extends Model
{
    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    protected $table = 'volunteer_years_of_experience';

    protected $fillable = ['name'];
}
