<?php

namespace App\Models\Volunteers\Surveys;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    public $timestamps = false;
    protected $table = 'volunteer_survey_sources';
    protected $fillable = ['name'];
}
