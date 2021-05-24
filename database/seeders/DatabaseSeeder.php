<?php


namespace Aigletter\Ticket\Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategoriesSeeder::class,
            PrioritiesSeeder::class,
            StatusesSeeder::class,
        ]);
    }
}