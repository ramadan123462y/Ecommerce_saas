<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = $this->faker->name();
        return [

            'name' => $name,

            'status' => rand(1, 0),
            'slug' => Str::slug($name),
            'description'=>$this->faker->sentence(),
            'meta_title'=>'adfhg',
            'meta_descrip'=>'adfhg',
            'meta_keywords'=>'adfhg',
            'file_name' => public_path('storage/Images/Categories/paymob.JPG'),
            'store_id' => Store::inRandomOrder()->first()->id
        ];
    }
}
