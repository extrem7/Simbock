<?php

namespace App\Models\Jobs;

use App\Models\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;

class Sector extends Model implements Sortable
{
    use SortableTrait;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = ['name'];

    protected $table = 'sectors';

    // RELATIONS
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'sector_has_roles', 'sector_id', 'role_id');
    }
}
