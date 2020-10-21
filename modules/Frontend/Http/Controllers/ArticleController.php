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
        $title = 'Newsroom';
        if ($category) $title = "$category->name | $title";
        $this->seo()->setTitle($title);

        $query = $category ? $category->articles() : Article::query();

        $articles = $query->published()
            ->withImage()
            ->with(['category' => fn($q) => $q->select(['id', 'slug'])])
            ->orderByDesc('id')
            ->paginate(6, ['id', 'category_id', 'title', 'slug', 'excerpt']);

        $articles = ArticleResource::collection($articles);

        if (request()->expectsJson()) return $articles;

        share(compact('articles'));

        $categories = $this->repository->getCategories($category);

        return view('frontend::articles.index', compact('categories', 'category'));
    }

    public function show(Category $category, Article $article)
    {
        $this->seo()->setTitle("$article->title | Newsroom");

        $categories = $this->repository->getCategories($category);
        return view('frontend::articles.show', compact('categories', 'category', 'article'));
    }
}
