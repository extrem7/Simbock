<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'job_incentives';

    protected $fillable = ['name'];
}
