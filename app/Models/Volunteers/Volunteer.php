<?php

namespace App\Models\Volunteers;

use App\Models\Jobs\Job;
use App\Models\Jobs\Skill;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Volunteer extends Model implements HasMedia
{
    use InteractsWithMedia;

    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $fillable = [
        'phone', 'email', 'social', 'headline', 'city_id', 'zip', 'is_relocating', 'is_working_remotely',
        'years_of_experience_id', 'level_of_education_id', 'veteran_status_id', 'has_driver_license', 'has_car'
    ];
    protected $casts = [
        'social' => 'array',
        'is_relocating' => 'boolean',
        'is_working_remotely' => 'boolean',
        'has_driver_license' => 'boolean',
        'has_car' => 'boolean'
    ];

    // FUNCTIONS

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('icon')
                    ->width(110)
                    ->sharpen(0)
                    ->nonQueued();
            });
    }

    public function uploadAvatar(UploadedFile $image = null)
    {
        if ($this->avatarMedia) $this->deleteMedia($this->avatarMedia);

        $this->addMedia($image)->toMediaCollection('avatar');
    }

    public function getAvatar(string $size = ''): string
    {
        if ($this->avatarMedia !== null) {
            return $this->avatarMedia->getUrl($size);
        } else {
            return asset_admin('img/no-avatar.png');
        }
    }

    // RELATIONS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'volunteer_has_skills');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'volunteer_has_languages');
    }

    public function avatarMedia()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'avatar');
    }
}
