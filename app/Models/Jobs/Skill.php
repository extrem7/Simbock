<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'job_skills';

    protected $fillable = ['name'];
}
