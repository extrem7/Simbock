<?php

namespace App\Models\Volunteers;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Resume extends Model
{
    const UPDATED_AT = null;
    protected $table = 'volunteer_resumes';
    protected $fillable = ['title', 'file_id'];

    public function file()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'resume');
    }
}
