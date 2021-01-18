<?php

namespace App\Models\Volunteers\Surveys;

use App\Models\Volunteers\Volunteer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'volunteer_surveys';

    protected $fillable = [
        'source_id', 'specified', 'name', 'email', 'address', 'phone', 'company_name', 'description'
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}
