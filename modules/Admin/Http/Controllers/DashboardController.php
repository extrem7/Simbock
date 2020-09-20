<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Blog\Article;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Dashboard');

        $counts = [];

        $counts['articles'] = Article::count();
        $counts['users'] = User::count();

        return view('admin::dashboard', $counts);
    }
}
