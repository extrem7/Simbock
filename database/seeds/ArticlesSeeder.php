<?php

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    public function run()
    {
        factory(Article::class, 10)
            ->create()
            ->each(fn(Article $a) => $a->addMediaFromUrl('https://picsum.photos/750/370')
                ->toMediaCollection('image'));
    }
}
