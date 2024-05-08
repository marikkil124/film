<?php

namespace App\Http\HttpClients\Film;
use Illuminate\Support\Facades\Http;


class FilmGetHttpClient
{
    public static function getFilms($data)
    {

        $film = implode(' ', $data);

        $response = Http::withHeaders([
            'X-API-KEY' => '1RRW571-ZH5MTEW-QS93T1P-RCWCMC1',
        ])->get('https://api.kinopoisk.dev/v1.4/movie/search?limit=4&query='. $film );

        return $response->body();

    }

}
