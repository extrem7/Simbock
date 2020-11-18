<?php

namespace App\Models\Volunteers;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'volunteer_work_experiences';

    protected $fillable = ['title', 'company', 'start', 'end', 'description'];
}
