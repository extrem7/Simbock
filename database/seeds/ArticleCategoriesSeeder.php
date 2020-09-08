<?php

use App\Models\Blog\Category;
use Illuminate\Database\Seeder;

class ArticleCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Volunteer Job', 'Companies Hiring Volunteer', 'Advice', 'Sports Volunteer', 'Simbok Updates'];
        foreach ($categories as $category) Category::create(['name' => $category]);
    }
}
