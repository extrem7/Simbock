<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Company extends Model implements HasMedia
{
    use InteractsWithMedia;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = [
        'title', 'sector_id', 'description', 'size_id',
        'address', 'address_2', 'city_id', 'state_id', 'zip',
        'phone', 'email', 'social'
    ];

    protected $casts = [
        'social' => 'array'
    ];

    // FUNCTIONS
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('icon')
                    ->width(110)
                    ->sharpen(0)
                    ->nonQueued();
            });
    }

    public function uploadLogo(UploadedFile $image = null)
    {
        if ($this->logoMedia) $this->deleteMedia($this->logoMedia);

        $this->addMedia($image)->toMediaCollection('logo');
    }

    public function getLogo(string $size = ''): string
    {
        if ($this->logoMedia !== null) {
            return $this->logoMedia->getUrl($size);
        } else {
            return asset_admin('img/no-logo.png');
        }
    }

    // RELATIONS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }

    public function logoMedia()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'logo');
    }
}
