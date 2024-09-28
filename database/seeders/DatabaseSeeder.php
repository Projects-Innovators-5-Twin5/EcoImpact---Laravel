<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Appel du seeder pour les articles
        $this->call(ArticleSeeder::class);
    }
}
