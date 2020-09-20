<?php

namespace Modules\Frontend\Http\Resources;

use App\Models\Blog\Article;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleResource extends JsonResource
{
    public static function collection($resource)
    {
        /* @var $collection LengthAwarePaginator */
        $collection = parent::collection($resource);
        return [
            'data' => $collection,

            'lastPage' => $collection->lastPage(),
            'currentPage' => $collection->currentPage()
        ];
    }

    public function toArray($request): array
    {
        /* @var $article Article */
        $article = $this->resource;
        return [
            'title' => $article->title,
            'excerpt' => $article->excerpt,
            'thumbnail' => $article->thumbnail,
            'link' => $article->link
        ];
    }
}
