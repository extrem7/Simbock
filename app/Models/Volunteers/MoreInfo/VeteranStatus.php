<?php

namespace App\Models\Volunteers\MoreInfo;

use Illuminate\Database\Eloquent\Model;

class VeteranStatus extends Model
{
    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    protected $table = 'volunteer_veteran_statuses';

    protected $fillable = ['name'];
}
