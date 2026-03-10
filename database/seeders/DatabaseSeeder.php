<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Restaurant',
            'email' => 'admin@restoran.com',
            'password' => bcrypt('password'),
        ]);

        $categories = [
            ['name' => 'Main Course', 'slug' => 'main-course', 'icon' => 'utensils'],
            ['name' => 'Drinks', 'slug' => 'drinks', 'icon' => 'coffee'],
            ['name' => 'Snacks', 'slug' => 'snacks', 'icon' => 'pizza'],
            ['name' => 'Desserts', 'slug' => 'desserts', 'icon' => 'ice-cream'],
        ];

        foreach ($categories as $cat) {
            $category = Category::create($cat);
            MenuItem::factory(10)->create(['category_id' => $category->id]);
        }

        Table::factory(15)->create();
    }
}
