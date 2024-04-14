<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\VideoContent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {

        return [

           'title'=>fake()->title,
           'genre_id'=>Genre::all()->pluck('id')->random(),
           'video_content_id'=>VideoContent::all()->pluck('id')->random(),
           'rating'=>fake()->randomFloat(2)

        ];
    }

}
