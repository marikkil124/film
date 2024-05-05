<?php

namespace App\Http\HttpClients\Film;
use Illuminate\Support\Facades\Http;


class FilmGetHttpClient
{
    public static function getFilms()
    {



        $response = Http::get('https://kinobox.tv/api/films/popular');

        return $response->body();



    }

}
