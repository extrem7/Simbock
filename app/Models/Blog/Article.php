<?php

namespace App\Models\Blog;

use App\Models\Traits\SearchTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use Sluggable;
    use InteractsWithMedia;
    use SearchTrait;

    public const DRAFT = 'DRAFT';
    public const PUBLISHED = 'PUBLISHED';

    public static $statuses = [
        self::DRAFT => 'Draft',
        self::PUBLISHED => 'Published'
    ];

    protected $fillable = [
        'category_id', 'title', 'slug', 'excerpt', 'body', 'meta_title', 'meta_description', 'status'
    ];

    protected $search = [
        'title', 'excerpt'
    ];

    // FUNCTIONS
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumbnail')
                    ->crop('crop-center', 370, 250)
                    ->sharpen(0)
                    ->nonQueued();
            });
    }

    public function uploadImage(UploadedFile $image = null): ?Media
    {
        if ($this->imageMedia) $this->deleteMedia($this->imageMedia);
        return $this->addMedia($image)->toMediaCollection('image');
    }

    public function getImage(string $size = ''): string
    {
        if ($this->imageMedia !== null) {
            return url($this->imageMedia->getUrl($size));
        } else {
            return asset('dist/img/no-image.jpg');
        }
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => !empty($this->slug) ? 'slug' : 'title',
                'onUpdate' => true,
            ]
        ];
    }

    // RELATIONS
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function imageMedia()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image');
    }

    // SCOPES
    public function scopePublished($query)
    {
        return $query->whereStatus(self::PUBLISHED);
    }

    public function scopeWithImage($query)
    {
        return $query->with('imageMedia');
    }

    //SETTERS
    public function setExcerptAttribute(string $excerpt)
    {
        $this->attributes['excerpt'] = strip_tags($excerpt);
    }

    // ACCESSORS
    public function getImageAttribute()
    {
        return $this->getImage();
    }

    public function getThumbnailAttribute()
    {
        return $this->getImage('thumbnail');
    }

    public function getLinkAttribute()
    {
        return route('frontend.articles.show', [
            'category' => $this->category->slug,
            'article' => $this->slug
        ]);
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('d M, Y');
    }
}
