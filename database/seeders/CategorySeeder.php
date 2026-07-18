<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Diver', 'slug' => 'diver'],
            ['name' => 'Chronograph', 'slug' => 'chronograph'],
            ['name' => 'Dress', 'slug' => 'dress'],
            ['name' => 'Classic', 'slug' => 'classic'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
