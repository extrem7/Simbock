<?php

namespace Modules\Admin\Repositories;

use App\Models\Blog\Article;
use App\Models\Blog\Category;

class ArticleRepository
{
    public function shareForCRUD(): void
    {
        $categories = Category::ordered()
            ->pluck('id', 'name')
            ->map(fn($value, $text) => compact('value', 'text'))
            ->values();
        $statuses = collect(Article::$statuses)
            ->map(fn($text, $value) => compact('text', 'value'))
            ->values();

        share(compact('categories', 'statuses'));
    }
}
