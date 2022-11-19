<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'blog_id' => 1,
            'title' => 'Article1',
            'body' => 'That/`s what you get from DeHavilland. We scan information from a vast range of institutional sources, European Parliament Committees, trade associations, databases, blogs, press and social media. We search out what/`s relevant to your industry. We distil the data into digestible reports that really clue you in. Now and far on the horizon.',
            'published_at' => now()->subDays(30),
            'created_at' => now()->subDays(30),
        ]);
        DB::table('articles')->insert([
            'blog_id' => 1,
            'title' => 'Article2',
            'body' => 'We make it effortless for you. Your own agile, dedicated team of political analysts, backed by sophisticated tech, cutting through the noise to highlight what really matters.',
            'published_at' => now()->subDays(11),
            'created_at' => now()->subDays(11),
        ]);
        DB::table('articles')->insert([
            'blog_id' => 2,
            'title' => 'Article3',
            'body' => 'I use DeHavilland every day and cannot over-emphasise the value to a company like ours.',
            'published_at' => now()->subDays(8),
            'created_at' => now()->subDays(8),
        ]);
        DB::table('articles')->insert([
            'blog_id' => 2,
            'title' => 'Article4',
            'body' => 'DeHavilland provides supporting information which is fundamental to us. The reports provided have been exceptionally helpful and the service is excellent, timely and vital to our business.',
            'published_at' => now()->subDays(5),
            'created_at' => now()->subDays(5),
        ]);
        DB::table('articles')->insert([
            'blog_id' => 1,
            'title' => 'Article5',
            'body' => 'All rights reserved. All use is subject to our Terms & Conditions and Privacy & Cookie Policy. Read our GDPR statement.',
            'published_at' => now(),
            'created_at' => now(),
        ]);
    }
}
