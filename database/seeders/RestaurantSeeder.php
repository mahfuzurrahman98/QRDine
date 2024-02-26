<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RestaurantSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@qrdine.com',
            'password' => bcrypt('qrd@24'),
        ]);
        
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                $restaurant = Restaurant::factory()->create([
                    'user_id' => $user->id,
                ]);

                $restaurant->categories()->saveMany(
                    Category::factory()->count(15)->create([
                        'restaurant_id' => $restaurant->id,
                    ])->each(function ($category) {
                        $category->items()->saveMany(Item::factory()->count(rand(3, 7))->create([
                            'category_id' => $category->id,
                        ]));
                    })
                );
            });
    }
}
