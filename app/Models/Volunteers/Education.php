<?php

namespace App\Models\Volunteers;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $table = 'volunteer_educations';
    protected $fillable = ['school', 'degree', 'field', 'start', 'end', 'description'];
}
