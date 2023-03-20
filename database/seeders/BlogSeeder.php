<?php

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogs = [
            [
                'slug' => 'blog-post-1',
                'title' => 'First Blog Post',
                'description' => 'This is the first blog post.',
            ],
            [
                'slug' => 'blog-post-2',
                'title' => 'Second Blog Post',
                'description' => 'This is the second blog post.',
            ],
            [
                'slug' => 'blog-post-3',
                'title' => 'Third Blog Post',
                'description' => 'This is the third blog post.',
            ],
            [
                'slug' => 'blog-post-4',
                'title' => 'Fourth Blog Post',
                'description' => 'This is the fourth blog post.',
            ],
            [
                'slug' => 'blog-post-5',
                'title' => 'Fifth Blog Post',
                'description' => 'This is the fifth blog post.',
            ],
            [
                'slug' => 'blog-post-6',
                'title' => 'Sixth Blog Post',
                'description' => 'This is the sixth blog post.',
            ],
            [
                'slug' => 'blog-post-7',
                'title' => 'Seventh Blog Post',
                'description' => 'This is the seventh blog post.',
            ],
            [
                'slug' => 'blog-post-8',
                'title' => 'Eighth Blog Post',
                'description' => 'This is the eighth blog post.',
            ],
            [
                'slug' => 'blog-post-9',
                'title' => 'Ninth Blog Post',
                'description' => 'This is the ninth blog post.',
            ],
            [
                'slug' => 'blog-post-10',
                'title' => 'Tenth Blog Post',
                'description' => 'This is the tenth blog post.',
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
