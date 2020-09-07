<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{

    public function shareForCRUD(): void
    {
        $statuses = collect(Article::$statuses)->map(fn($val, $key) => ['value' => $key, 'label' => $val])->values();

        share([
            'statuses' => $statuses
        ]);
    }
}
