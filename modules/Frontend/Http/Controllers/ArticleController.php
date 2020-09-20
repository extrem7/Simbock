<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Blog\Article;
use App\Models\Blog\Category;
use Modules\Frontend\Http\Resources\ArticleResource;
use Modules\Frontend\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    protected ArticleRepository $repository;

    public function __construct()
    {
        $this->repository = app(ArticleRepository::class);
    }

    public function index(Category $category = null)
    {
        $query = $category ? $category->articles() : Article::query();

        $articles = $query->published()
            ->withImage()
            ->with(['category' => fn($q) => $q->select(['id', 'slug'])])
            ->orderByDesc('id')
            ->paginate(6, ['id', 'category_id', 'title', 'slug', 'excerpt']);

        $articles = ArticleResource::collection($articles);

        $categories = $this->repository->getCategories($category);

        return [$articles, $categories];
    }

    public function show(Category $category, Article $article)
    {
        $categories = $this->repository->getCategories($category);
        return [$article, $categories];
    }
}
