<?php

namespace App\Models\Volunteers;

use App\Models\Jobs\Hour;
use App\Models\Jobs\Role;
use App\Models\Jobs\Skill;
use App\Models\Jobs\Type;
use App\Models\Language;
use App\Models\Map\US\City;
use App\Models\User;
use App\Models\Vacancy;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Volunteer extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    protected $fillable = [
        'is_private', 'phone', 'email', 'social', 'headline', 'city_id', 'zip', 'is_relocating', 'is_working_remotely',
        'job_title', 'executive_summary', 'objective', 'achievements', 'associations', 'years_of_experience_id',
        'level_of_education_id', 'veteran_status_id', 'cover_letter', 'personal_statement',
        'has_driver_license', 'has_car', 'completeness'
    ];

    protected $casts = [
        'social' => 'array',
        'is_relocating' => 'boolean',
        'is_working_remotely' => 'boolean',
        'has_driver_license' => 'boolean',
        'has_car' => 'boolean',
        'completeness' => 'float'
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
        $this->addMediaCollection('resume')->singleFile();
    }

    public function uploadAvatar(UploadedFile $image = null): void
    {
        if ($this->avatarMedia) $this->deleteMedia($this->avatarMedia);

        $this->addMedia($image)->toMediaCollection('avatar');
    }

    public function deleteAvatar(): bool
    {
        return $this->avatarMedia->delete();
    }

    public function getAvatar(string $size = ''): string
    {
        if ($this->avatarMedia !== null) {
            return $this->avatarMedia->getUrl($size);
        }

        return asset('dist/img/avatar.svg');
    }

    public function calculateCompleteness(): void
    {
        $completeness = 0;

        $steps = [
            'about' => [
                'value' => ($this->name && $this->headline && $this->city_id),
                'cost' => 0.2
            ],
            'looking' => [
                'value' => $this->roles()->exists(),
                'cost' => 0.2
            ],
            'work_experience' => [
                'value' => $this->workExperiences()->exists(),
                'cost' => 0.2
            ],
            'contact_social' => [
                'value' => ($this->email && $this->phone && !empty(array_filter($this->social, fn($l) => $l !== null))),
                'cost' => 0.2
            ],
            'skills' => [
                'value' => $this->skills()->exists(),
                'cost' => 0.2
            ],
        ];

        foreach ($steps as $step) {
            $completeness += $step['value'] ? $step['cost'] : 0;
        }

        $this->update(['completeness' => $completeness]);
    }

    // RELATIONS
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applies(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class, 'volunteer_has_applies')->distinct();
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class, 'volunteer_has_bookmarks');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /* @return City[]|Collection|BelongsToMany */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'volunteer_has_locations');
    }

    /* @return City[]|Collection|BelongsToMany */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'volunteer_has_sectors_with_roles')->withPivot(['sector_id']);
    }

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'volunteer_has_types');
    }

    public function hours(): BelongsToMany
    {
        return $this->belongsToMany(Hour::class, 'volunteer_has_hours');
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    /* @return Resume|HasOne */
    public function resume(): HasOne
    {
        return $this->hasOne(Resume::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'volunteer_has_skills');
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'volunteer_has_languages')->withPivot(['fluency']);
    }

    public function avatarMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'avatar');
    }

    // ACCESSORS
    public function getAvatarAttribute(): string
    {
        return $this->getAvatar();
    }

    public function getIconAttribute(): string
    {
        return $this->getAvatar('icon');
    }

    public function getNameAttribute(): ?string
    {
        return $this->user->name;
    }

    public function getEmailAttribute(string $email = null): string
    {
        return $email ?: $this->user->email;
    }

    public function getUpdatedAtAttribute(): string
    {
        return $this->user->updated_at->diffForHumans();
    }

    //todo refactor to trait HasLocation
    public function getLocationAttribute(): string
    {
        $c = $this->city;
        $name = $c->name;
        if ($c->name !== $c->county) $name .= ", $c->county";
        return "$name $c->state_id";
    }

    //todo refactor to trait HasEmployment
    public function getEmploymentAttribute(): string
    {
        return $this->types->implode('name', ', ')
            . ', '
            . $this->hours->implode('name', ', ');
    }

    public function getInBookmarksAttribute(): bool
    {
        if ($user = Auth::user()) {
            return $user->company->bookmarks()->where('volunteer_id', $this->id)->exists();
        }
        return false;
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->completeness === 1.;
    }
}
