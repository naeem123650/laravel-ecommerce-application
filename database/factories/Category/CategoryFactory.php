<?php

namespace Database\Factories\Category;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name =  $this->faker->text(10);
        $slug = Str::slug($name);
        return [
            "name" => $name,
            "slug" => $slug,
            "parent_id" => 1,
            "menu" => 1,
        ];
    }
}
