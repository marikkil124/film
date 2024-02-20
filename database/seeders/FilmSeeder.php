<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\GenreName;
use Database\Factories\FilmFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Film::factory()->count(3)->create();
    }
}
