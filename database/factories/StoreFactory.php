<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'title' => "titile",
            'sub_domain' => $this->faker->word(5),
            'plan_id' => Plan::inRandomOrder()->first()->id,
        ];
    }
}
