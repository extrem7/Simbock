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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use SoftDeletes;
    use SearchTrait;

    public const DRAFT = 'DRAFT';
    public const PUBLISHED = 'PUBLISHED';
    public const STOPPED = 'STOPPED';
    public const CLOSED = 'CLOSED';

    public static $statuses = [
        self::DRAFT => 'Draft',
        self::PUBLISHED => 'Published',
        self::STOPPED => 'Stopped',
        self::CLOSED => 'Closed'
    ];

    protected $fillable = [
        'title', 'sector_id', 'city_id', 'type_id', 'description', 'is_relocation', 'is_remote_work',
        'address', 'company_title', 'company_description', 'status'
    ];

    protected array $search = ['title'];

    //FUNCTIONS

    public static function boot()
    {
        foreach (['creating', 'updating', 'saving'] as $event) static::$event(fn(self $a) => $a->generateExcerpt());
        parent::boot();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // RELATIONS

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

    public function getLocationAttribute()
    {
        $city = $this->city;
        return "$city->name, {$city->state_id}";
    }

    // ACCESSORS

    public function getEmploymentAttribute()
    {
        return $this->type->name . ', ' . $this->hours->join(', ');
    }

    public function getCompanyTitleAttribute(string $company_title = null)
    {
        return $company_title ?? $this->company->title;
    }

    public function getCompanyDescriptionAttribute(string $company_description = null)
    {
        return $company_description ?? $this->company->description;
    }

    protected function generateExcerpt(): void
    {
        $excerpt = mb_substr($this->description, 0, 190);
        $excerpt = preg_replace('/\W\w+\s*(\W*)$/', '$1', $excerpt);
        $this->excerpt = $excerpt;
    }
}
