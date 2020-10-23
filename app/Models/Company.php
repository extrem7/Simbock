<?php

namespace App\Models;

use App\Models\Jobs\Size;
use App\Models\Map\US\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'name', 'title', 'sector_id', 'description', 'size_id',
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

    public function deleteLogo(): bool
    {
        return $this->logoMedia->delete();
    }

    public function getLogo(string $size = ''): string
    {
        if ($this->logoMedia !== null) {
            return $this->logoMedia->getUrl($size);
        } else {
            return asset('dist/img/avatar.svg');
        }
    }

    // RELATIONS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* @return Vacancy|HasMany */
    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }

    public function logoMedia()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'logo');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    // ACCESSORS
    public function getLogoAttribute()
    {
        return $this->getLogo();
    }

    public function getEmploymentAttribute()
    {
        return ($this->title ? "$this->title , " : '') . $this->size->name;
    }

    public function getLocationAttribute()
    {
        $c = $this->city;
        $name = $c->name;
        if ($c->name !== $c->county) $name .= ", $c->county";
        return "$name $c->state_id";
    }
}
