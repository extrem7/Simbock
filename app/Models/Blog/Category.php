<?php

namespace App\Models\Blog;

use App\Models\Traits\SortableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

use Spatie\EloquentSortable\Sortable;

class Category extends Model implements Sortable
{
    use Sluggable;
    use SortableTrait;

    protected $table = 'article_categories';

    protected $fillable = ['name', 'slug', 'is_active'];

    // FUNCTIONS
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'name',
                'onUpdate' => true,
            ]
        ];
    }

    // RELATIONS
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    //SCOPES
    public function scopeActive($query)
    {
        return $query->whereIsActive(true);
    }

    // ACCESSORS
    public function getLinkAttribute()
    {
        return route('frontend.articles.category', $this->slug);
    }
}
