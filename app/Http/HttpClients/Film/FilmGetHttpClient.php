<?php

namespace App\Http\HttpClients\Film;

use App\Models\Film;
use App\Models\VideoContent;
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
            $map['film_id_api'] = $item['id'];
            $map['title'] = $item['name'];
            $map['title_eng'] = $item['alternativeName'];
            $map['url'] = $item['poster']['url'];
            $map['year'] = $item['year'];
            $map['genres'] = $item['genres'];
            $map['type'] = self::getTypeFilm($item['type']);
            $map['type_number'] = $item['typeNumber'];
            $maps[$item['id']] = $map;
        }

        return $maps;


    }

    public static function getTypeFilm($type)
    {
        $map = [];
        $arr = array_search($type,VideoContent::getType);

        $map[$arr] = $type;

           return $map ;

    }

}
