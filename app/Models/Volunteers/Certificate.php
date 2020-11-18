<?php

namespace App\Models\Volunteers;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'volunteer_certificates';

    protected $fillable = ['title', 'issuing_authority', 'year', 'description'];
}
