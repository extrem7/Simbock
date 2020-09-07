<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Article;
use App\Models\Rss\Channel;
use App\Models\Rss\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Dashboard');

        return view('admin::dashboard');
    }
}
