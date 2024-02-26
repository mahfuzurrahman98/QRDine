<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory {
    private function makelug($name) {
        // convert to lowercase
        $name = strtolower($name);
        // replace anything rather than alphanumeric with space
        $name = preg_replace("/[^a-zA-Z0-9\s]/", "", $name);
        // split the name into words
        $words = explode(" ", $name);

        // Take the first two words, join them, and limit to 30 characters
        $slug = substr(implode("", array_slice($words, 0, 2)), 0, 30);

        return $slug;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $name = $this->faker->company;
        $slug = $this->makelug($name);
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'user_id' => 0,
        ];
    }
}
