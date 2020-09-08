<?php

namespace App\Models\Traits;

use Spatie\EloquentSortable\SortableTrait as BaseSortableTrait;

trait SortableTrait
{
    use BaseSortableTrait;

    public $sortable = [
        'order_column_name' => 'order'
    ];
}
