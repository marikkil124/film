<?php

namespace App\Services;

use App\Models\Film;

class FilmService
{
    public static function store(array $data)
    {
        $genres = $data['genres'];
        unset($data['genres']);

        $film = Film:: create($data);
        foreach ($genres as $genre) {
            $film->genre()->attach($genre);
        }
        return $film;
    }

}
