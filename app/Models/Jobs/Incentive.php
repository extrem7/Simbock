<?php

namespace App\Models\Jobs;

use App\Models\Traits\IsTag;
use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    use IsTag;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'job_incentives';

    protected $fillable = ['name'];
}
