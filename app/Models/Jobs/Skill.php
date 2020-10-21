<?php

namespace App\Models\Jobs;

use App\Models\Traits\IsTag;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use IsTag;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'job_skills';

    protected $fillable = ['name'];
}
