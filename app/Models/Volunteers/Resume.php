<?php

namespace App\Models\Volunteers;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Resume extends Model
{
    public const UPDATED_AT = null;

    protected $table = 'volunteer_resumes';

    protected $fillable = ['title', 'file_id'];

    protected $appends = ['url'];

    public function file(): Media
    {
        return Media::find($this->file_id);
    }

    public function getUrlAttribute(): string
    {
        return $this->file()->getFullUrl();
    }
}
