<?php

namespace Modules\Admin\Http\Requests\Blog;

use App\Models\Blog\Article;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function rules()
    {
        $update = request()->isMethod('PATCH');
        $types = collect(Article::$statuses)->keys()->implode(',');

        return [
            'category_id' => ['required', 'exists:article_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'excerpt' => ['required', 'string', 'max:510'],
            'image' => [$update ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,bmp,png'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', "in:$types"],
        ];
    }

    public function uploadImage(Article $article): bool
    {
        if ($this->hasFile('image')) {
            return $article->uploadImage($this->file('image')) !== null;
        }
        return false;
    }

    public function authorize()
    {
        return true;
    }
}
