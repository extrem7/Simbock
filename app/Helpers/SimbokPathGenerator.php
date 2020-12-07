<?php

namespace App\Helpers;

use App\Models\Blog\Article;
use App\Models\Company;
use App\Models\User;
use App\Models\Volunteers\Volunteer;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class SimbokPathGenerator implements PathGenerator
{

    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    protected function getBasePath(Media $media): string
    {
        $folder = '';
        $collection = $media->collection_name;

        switch ($media->model_type) {
            case Article::class:
                return "articles/" . $media->model_id . "/$collection";
                break;
            case Volunteer::class:
                return "volunteers/" . $media->model_id . "/$collection";
                break;
            case Company::class:
                return "companies/" . $media->model_id . "/$collection";
                break;
        }

        return "$folder/" . $media->model_id . "/$collection/" . $media->getKey();
    }
}
