<?php

namespace App\Models\Jobs;

use App\Models\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;

class Role extends Model implements Sortable
{
    use SortableTrait;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = ['name'];

    protected $table = 'sector_roles';

    // RELATIONS
    public function sectors()
    {
        return $this->belongsToMany(
            Sector::class, 'sector_has_roles', 'role_id', 'sector_id'
        );
    }
}
