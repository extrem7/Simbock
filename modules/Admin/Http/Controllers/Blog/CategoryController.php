<?php

namespace Modules\Admin\Http\Controllers\Blog;

use Modules\Admin\Http\Requests\Blog\CategoryRequest;
use App\Models\Blog\Category;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Controllers\Traits\CRUDController;
use Modules\Admin\Http\Controllers\Traits\SortableController;

class CategoryController extends Controller
{
    use SortableController;
    use CRUDController;

    protected $model = Category::class;

    protected string $modelClass = Category::class;
    protected string $resource = 'article-categories';

    public function index()
    {
        $this->seo()->setTitle('Blog categories');

        $categories = Category::ordered()->withCount('articles')->get();
        share(compact('categories'));

        return view('admin::crud.index', ['resource' => 'article-categories']);
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new category');

        return $this->form();
    }

    public function store(CategoryRequest $request)
    {
        $this->seo()->setTitle('Edit a category');

        $category = Category::create($request->validated());

        return response()->json([
            'status' => 'Category has been created',
            'title' => $this->seo()->getTitle(),
            'category' => $category
        ], 201);
    }

    public function edit(Category $category)
    {
        $this->seo()->setTitle('Edit a category');

        share(compact('category'));

        return $this->form();
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json(['status' => 'Category has been updated', 'category' => $category]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['status' => 'Category has been deleted']);
    }
}
