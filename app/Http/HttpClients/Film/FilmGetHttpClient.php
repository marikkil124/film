<?php

namespace App\Http\HttpClients\Film;

use App\Models\Film;
use App\Models\Image;
use App\Models\VideoContent;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;


class FilmGetHttpClient
{
    public static function getFilms($data)
    {

        $film = implode(' ', $data);
        $response = Http::withHeaders([
            'X-API-KEY' => '1RRW571-ZH5MTEW-QS93T1P-RCWCMC1',
        ])->get('https://api.kinopoisk.dev/v1.4/movie/search?limit=20&query=' . $film);
        $filmsAPI = [];
        foreach ($response->json('docs') as $item) {

            $filmId = Film::where('film_id_api', $item['id'])->get();
            $map = [];
            $map['film_id_api'] = $item['id'];
            $map['title'] = $item['name'];
            $map['title_eng'] = $item['alternativeName'];
            $map['url'] = $item['poster']['url'] ?? Image::NOT_FOUND_IMAGE;
            $map['year'] = $item['year'];
            $map['genres'] = $item['genres'];
            $map['type'] = self::getTypeFilm($item['typeNumber']);
            $map['type_number'] = $item['typeNumber'];
            $map['description'] = $item['shortDescription'];
            $map['count'] =1 ;

            //проверка есть ли в моих фильмах фильм из апи
            if ($filmId->isNotEmpty())
                $map['is_my_film'] = Film::IsMyFilm($filmId->first());
            else
                $map['is_my_film'] = false;

            $filmsAPI[$item['id']] = $map;

        }



        $perPage = 5;
        $filmsCollection = collect($filmsAPI);



        $page = request()->get('page', 1);

        $paginatedFilms = new LengthAwarePaginator(
            $filmsCollection->forPage($page, $perPage),
            $filmsCollection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );


        return $paginatedFilms;
    }

    public static function getTypeFilm($type)
    {
        switch ($type) {
            case VideoContent::FILM:
                return 'Фильмы';

            case VideoContent::SERIAL:
                return 'Сериалы';
            case VideoContent::CARTOON:
                return 'Анимация';

            case VideoContent::ANIME:
                return 'Аниме';

            case VideoContent::ANIMATED_SERIES:
                return 'Аниме-сериал';
        }
    }




}
