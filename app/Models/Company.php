<?php

namespace App\Models;

use App\Models\Jobs\Size;
use App\Models\Map\US\City;
use App\Models\Traits\SearchTrait;
use App\Models\Volunteers\Volunteer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Laravel\Cashier\Billable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Company extends Model implements HasMedia
{
    use InteractsWithMedia,
        Billable,
        SoftDeletes,
        SearchTrait;

    public const CREATED_AT = null;
    public const UPDATED_AT = null;

    protected $fillable = [
        'name', 'title', 'sector_id', 'description', 'size_id',
        'address', 'address_2', 'city_id', 'state_id', 'zip',
        'phone', 'email', 'social',
        'card_brand', 'card_last_four', 'resume_views'
    ];

    protected $casts = [
        'social' => 'array'
    ];

    protected $dates = [
        'trial_ends_at'
    ];

    protected array $search = [
        'id', 'name'
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

    public function uploadLogo(UploadedFile $image = null): void
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
        }

        return asset('dist/img/avatar.svg');
    }

    public function getPlan(): ?array
    {
        $plans = collect(config('simbok.plans'));
        if ($subscription = $this->subscription()) {
            return $plans->where('stripe_plan', $subscription->stripe_plan)->first();
        }
    }

    public function canSeeVolunteer(): bool
    {
        if ($this->subscribed() && $plan = $this->getPlan()) {
            $limit = $this->getAvailableVolunteersCount();
            return $limit === -1 || $this->resume_views < $limit;
        }
        return false;
    }

    public function canPostVacancy(): bool
    {
        if ($this->subscribed() && $plan = $this->getPlan()) {
            $limit = $plan['limits']['vacancies'];
            return $limit === -1 || $this->vacancies()->count() < $limit;
        }
        return false;
    }

    public function getAvailableVolunteersCount(): int
    {
        if ($this->subscribed() && $plan = $this->getPlan()) {
            return $plan['limits']['volunteers'];
        }
        return 0;
    }

    public function getAvailableCandidatesCount(): int
    {
        if ($this->subscribed() && $plan = $this->getPlan()) {
            $recommendations = $plan['limits']['recommendations'];
            return $recommendations === -1 ? 0 : $recommendations;
        }
        return 0;
    }

    // RELATIONS
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* @return Vacancy|HasMany */
    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    /* @return Collection<Volunteer> */
    public function candidates(): Collection
    {
        return $this->vacancies()
            ->with(['applies' => fn($q) => $q->select('id')])
            ->get('id')
            ->pluck('applies')
            ->flatten();
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class, 'company_has_bookmarks');
    }

    public function logoMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'logo');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    // ACCESSORS
    public function getLogoAttribute(): string
    {
        return $this->getLogo();
    }

    public function getEmailAttribute(string $email = null): string
    {
        return $email ?: $this->user->email;
    }

    public function getEmploymentAttribute(): string
    {
        return ($this->title ? "$this->title , " : '') . $this->size->name;
    }

    public function getLocationAttribute(): string
    {
        $c = $this->city;
        $name = $c->name;
        if ($c->name !== $c->county) $name .= ", $c->county";
        return "$name $c->state_id";
    }
}
