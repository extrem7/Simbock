<?php

namespace App\Models;

use App\Models\Traits\SearchTrait;
use App\Models\Volunteers\Volunteer;
use Modules\Frontend\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasRoles,
        Notifiable,
        InteractsWithMedia,
        SearchTrait;

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
        self::VOLUNTEER => 'Volunteer',
        self::COMPANY => 'Company'
    ];

    // FUNCTIONS
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // RELATIONS
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function volunteer()
    {
        return $this->hasOne(Volunteer::class);
    }

    // ACCESSORS
    public function getAvatarAttribute(): string
    {
        return $this->type === self::VOLUNTEER
            ? $this->volunteer->avatar
            : $this->company->logo;
    }

    public function getHasPasswordAttribute(): bool
    {
        return !empty($this->attributes['password']);
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
