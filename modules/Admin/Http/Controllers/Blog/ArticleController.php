<?php

namespace Modules\Admin\Http\Controllers\Blog;

use App\Models\Blog\Article;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\Blog\ArticleRequest;
use Modules\Admin\Http\Requests\IndexRequest;
use Modules\Admin\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    protected ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = app(ArticleRepository::class);
    }

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Blog articles');

        $sort = $request->get('sortDesc') ?? true;

        $articles = Article::query()->select(['id', 'slug', 'title', 'status', 'created_at', 'updated_at'])
            ->when($request->get('searchQuery'), fn($q) => $q->search($request->get('searchQuery')))
            ->orderBy($request->get('sortBy') ?? 'id', $sort ? 'desc' : 'asc')
            ->paginate(10);

        $articles->getCollection()->transform(function ($article) {
            $article['status'] = Article::$statuses[$article['status']];
            // $article['link'] = route('frontend.articles.show', $article->slug);
            return $article;
        });
        if (request()->expectsJson()) {
            return $articles;
        } else {
            share(compact('articles'));
        }

        return view('admin::articles.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new article');

        $this->articleRepository->shareForCRUD();

        return view('admin::articles.form');
    }

    public function store(ArticleRequest $request)
    {
        $this->seo()->setTitle('Edit an article');

        $article = Article::create($request->validated());

        if ($request->uploadImage($article)) {
            $article->load('imageMedia');
            $article->append('image');
        }

        return response()->json([
            'status' => 'Article has been created',
            'title' => $this->seo()->getTitle(),
            'article' => $article
        ], 201);
    }

    public function edit(Article $article)
    {
        $this->seo()->setTitle('Edit an article');

        $article->append('image');

        $this->articleRepository->shareForCRUD();

        share(compact('article'));

        return view('admin::articles.form');
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->validated());

        if ($request->uploadImage($article)) {
            $article->load('imageMedia');
            $article->append('image');
        }

        return response()->json(['status' => 'Article has been updated', 'article' => $article]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['status' => 'Article has been deleted']);
    }
}
