<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'jaison moraa',
            'email' => 'jaison@mail.com',
        ]);

        User::factory(29)->create();

        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            RecipeSeeder::class,
        ]);

        $recipes = Recipe::all();
        $tags = Tag::all();

        foreach ($recipes as $recipe) {
            $recipe->tags()->attach($tags->random(rand(2, 4)));
        }
    }
}
