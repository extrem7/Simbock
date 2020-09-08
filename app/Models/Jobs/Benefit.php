<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'job_company_benefits';

    protected $fillable = ['name'];
}
