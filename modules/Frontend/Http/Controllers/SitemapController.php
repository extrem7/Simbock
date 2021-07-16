<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog\Article;
use App\Models\Blog\Category;
use App\Models\Page;
use App\Models\Vacancy;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function __invoke(): Sitemap
    {
        $sitemap = new Sitemap;
        $links = collect([url('')]);

        Page::where('slug', '!=', 'home')->get('slug')->each(fn(Page $p) => $links[] = url($p->slug));

        $links[] = route('frontend.articles.index');
        Category::all('slug')->each(fn(Category $c) => $links[] = route('frontend.articles.category', $c->slug));
        Article::all(['category_id', 'slug'])->each(fn(Article $a) => $links[] = $a->link);

        $links[] = route('frontend.login');
        $links[] = route('frontend.register');

        $links[] = route('frontend.vacancies.search');
        Vacancy::active()->get('id')->each(fn(Vacancy $v) => $links[] = route('frontend.vacancies.show', $v->id));

        $links->each(fn(string $link) => $sitemap->add(new Url($link)));

        return $sitemap;
    }
}
