<?php

namespace Modules\Frontend\Repositories;

use App\Models\Blog\Category;

class ArticleRepository
{
    public function getCategories(Category $category = null)
    {
        return Category::ordered()->get(['slug', 'name'])->map(function (Category $c) use ($category) {
            $c->append('link');
            $c['is_active'] = $category && $category->slug == $c->slug;
            return $c;
        });
    }
}
