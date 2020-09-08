<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'job_types';

    protected $fillable = ['name'];
}
