<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blogs')->insert([
        	'title' => 'Blog1',
            'body' => 'Old blog',
        	'published_at' => now()->subDays(30),
            'created_at' => now()->subDays(30),
        ]);
        DB::table('blogs')->insert([
        	'title' => 'Blog2',
            'body' => 'New blog',
        	'published_at' => now()->subDays(15),
            'created_at' => now()->subDays(15),
        ]);
    }
}
