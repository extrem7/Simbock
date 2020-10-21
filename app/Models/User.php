<?php

namespace App\Models;

use App\Models\Traits\SearchTrait;
use Modules\Frontend\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasRoles;
    use Notifiable;
    use InteractsWithMedia;
    use SearchTrait;

    protected $fillable = [
        'name', 'email', 'provider', 'provider_id', 'password', 'type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $search = [
        'email', 'name'
    ];

    public const VOLUNTEER = 'VOLUNTEER';
    public const COMPANY = 'COMPANY';

    public static $types = [
        self::VOLUNTEER => 'Draft',
        self::COMPANY => 'Company'
    ];

    // FUNCTIONS
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('icon')
                    ->crop('crop-center', 100, 100)
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // RELATIONS
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function avatarMedia()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'avatar');
    }

    // ACCESSORS
    public function getAvatarAttribute()
    {
        return $this->getAvatar();
    }

    public function getIconAttribute()
    {
        return $this->getAvatar('icon');
    }

    public function getIsSuperAdminAttribute(): bool
    {
        return $this->id === 1 || $this->email === env('INITIAL_USER_EMAIL');
    }

    public function getIsVolunteerAttribute(): bool
    {
        return $this->type === self::VOLUNTEER;
    }
}
