<?php

namespace App\Models\Chats;

use App\Models\Company;
use App\Models\Vacancy;
use App\Models\Volunteers\Volunteer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['volunteer_id', 'company_id', 'vacancy_id'];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }
}
