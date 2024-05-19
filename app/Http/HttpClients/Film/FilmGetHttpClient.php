<?php

namespace App\Http\HttpClients\Film;

use App\Models\Film;
use Illuminate\Support\Facades\Http;


class FilmGetHttpClient
{
    public static function getFilms($data)
    {

        $film = implode(' ', $data);
        $response = Http::withHeaders([
            'X-API-KEY' => '1RRW571-ZH5MTEW-QS93T1P-RCWCMC1',
        ])->get('https://api.kinopoisk.dev/v1.4/movie/search?limit=20&query=' . $film);
        $maps = [];
        foreach ($response->json('docs') as $item) {

            $map = [];
            $map['id'] = $item['id'];
            $map['title'] = $item['name'];
            $map['title_eng'] = $item['alternativeName'];
            $map['url'] = $item['poster']['url'];
            $map['year'] = $item['year'];
            $map['genres'] = $item['genres'];
            $map['type'] = self::getTypeFilm($item['type']);
            $maps[$item['id']] = $map;
        }
        return $maps;


    }

    public static function getTypeFilm($type)
    {
        if ($type == 'movie')
            return 'Фильмы';
        if ($type == 'tv-series')
            return 'Сериалы';
        if ($type == 'cartoon')
            return 'Анимация';
        else
            return $type;
    }

}
