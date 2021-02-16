<?php

namespace App\Models;

use App\Models\Interfaces\SearchRecordable;
use App\Models\Traits\SearchTrait;
use App\Models\Volunteers\Volunteer;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        SoftDeletes,
        CascadeSoftDeletes,
        SearchTrait;

    protected $fillable = [
        'name', 'email', 'provider', 'provider_id', 'password', 'type'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $cascadeDeletes = ['company', 'volunteer'];

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
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getClient(): ?Client
    {
        return $this->is_volunteer ? $this->volunteer : $this->company;
    }

    // RELATIONS

    /* @return Company|HasOne */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    /* @return Volunteer|HasOne */
    public function volunteer(): HasOne
    {
        return $this->hasOne(Volunteer::class);
    }

    // ACCESSORS
    public function getAvatarAttribute(): ?string
    {
        if ($this->type === self::VOLUNTEER) {
            if ($volunteer = $this->volunteer) {
                return $this->volunteer->avatar;
            }
        } else if ($company = $this->company) {
            return $this->company->logo;
        }
        return null;
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
