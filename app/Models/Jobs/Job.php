<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'volunteer_jobs';

    protected $fillable = ['title', 'locations', 'sector_id'];

    protected $casts = [
        'locations' => 'array'
    ];

    public function types()
    {
        return $this->belongsToMany(Type::class, 'volunteer_job_has_types');
    }

    public function hours()
    {
        return $this->belongsToMany(Hour::class, 'volunteer_job_has_hours');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'volunteer_job_has_roles');
    }
}
