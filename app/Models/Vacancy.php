<?php

namespace App\Models;

use App\Models\Jobs\Benefit;
use App\Models\Jobs\Hour;
use App\Models\Jobs\Incentive;
use App\Models\Jobs\Sector;
use App\Models\Jobs\Skill;
use App\Models\Jobs\Type;
use App\Models\Map\US\City;
use App\Models\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use SoftDeletes;
    use SearchTrait;

    public const DRAFT = 'DRAFT';
    public const ACTIVE = 'ACTIVE';
    public const CLOSED = 'CLOSED';

    public static $statuses = [
        self::DRAFT => 'Draft',
        self::ACTIVE => 'Published',
        self::CLOSED => 'Closed'
    ];

    protected $fillable = [
        'title', 'sector_id', 'city_id', 'type_id', 'description', 'is_relocation', 'is_remote_work',
        'address', 'company_title', 'company_description', 'status'
    ];

    protected $casts = [
        'is_applied' => 'bool',
        'is_bookmarked' => 'bool'
    ];

    protected array $search = ['title'];

    // FUNCTIONS
    public static function boot()
    {
        foreach (['creating', 'updating'] as $event) static::$event(fn(self $a) => $a->generateExcerpt());
        parent::boot();
    }

    protected function generateExcerpt(): void
    {
        $excerpt = mb_substr($this->description, 0, 190);
        $excerpt = preg_replace('/\W\w+\s*(\W*)$/', '$1', $excerpt);
        $this->excerpt = $excerpt;
    }

    // RELATIONS
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function hours()
    {
        return $this->belongsToMany(Hour::class, 'vacancy_has_hours');
    }

    public function benefits()
    {
        return $this->belongsToMany(Benefit::class, 'vacancy_has_benefits');
    }

    public function incentives()
    {
        return $this->belongsToMany(Incentive::class, 'vacancy_has_incentives');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'vacancy_has_skills');
    }

    // SCOPES
    public function scopeActive(Builder $query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function scopeDraft(Builder $query)
    {
        return $query->where('status', self::DRAFT);
    }

    public function scopeClosed(Builder $query)
    {
        return $query->where('status', self::CLOSED);
    }

    // ACCESSORS
    public function getIsAppliedAttribute(): bool
    {
        if ($user = \Auth::getUser()) {
            return $user->volunteer->applies()->where('vacancy_id', $this->id)->exists();
        }
        return false;
    }

    public function getInBookmarksAttribute(): bool
    {
        if ($user = \Auth::getUser()) {
            return $user->volunteer->bookmarks()->where('vacancy_id', $this->id)->exists();
        }
        return false;
    }

    public function getEmploymentAttribute(): string
    {
        return $this->type->name . ', ' . $this->hours->implode('name', ', ');
    }

    public function getDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getLocationAttribute(): string
    {
        $c = $this->city;
        $name = $c->name;
        if ($c->name !== $c->county) $name .= ", $c->county";
        return "$name $c->state_id";
    }
}
