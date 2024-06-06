<?php

namespace App\Services;

use App\Http\HttpClients\Film\FilmGetHttpClient;
use App\Http\Resources\Film\FilmResource;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Image;
use App\Models\VideoContent;

class FilmService
{
    public static function store($data, $genres)
    {
        $genreIds = [];
        $i = 0;

        foreach ($data['genres'] as $genre) {
            foreach ($genre as $name) {
                if ($genres->doesntContain('title', $name))
                    Genre::updateOrCreate(['title' => $name]);

                $genreId = Genre::where('title', $name)->pluck('id');
                $genreIds[$i] = $genreId[0];
                $i++;
            }
        }
        //добавление в свою базу из апи
        $film = Film::updateOrCreate(

            ['film_id_api' => $data['film_id_api']],
            [
                'title' => $data['title'],
                'title_eng' => $data['title_eng'],
                'year' => $data['year'],
                'video_content_id' => VideoContent::where('type_number', $data['type_number'])->pluck('id')->first() ?? null,
                'film_id_api' => $data['film_id_api'],
                'description' => $data['description'],
            ]);

            //Добавление в промежточную таблицу жанров
            $film->genre()->sync($genreIds);

        //добавлене изображения
        Image::updateOrcreate(

               ['path' => $data['url'] ?? Image::NOT_FOUND_IMAGE,
                'imageable_id' => $film->id,
                'imageable_type' => Film::class
            ]);

         //добавление в мои любимые фильмы
        auth()->user()->film()->syncWithoutDetaching($film->id);

        return FilmResource::make($film);
    }

    public static function index($data){


        $containsCyrillic =  preg_match('/[\p{Cyrillic}]/u', $data['title']);
        //если не кириллица искать в title_eng
        if (!$containsCyrillic) {
            $data['title_eng'] = $data['title'];
            unset($data['title']);
        }


        if (isset($data['title']) or isset($data['title_eng'])) {

            $FilmDataBase = Film::filter($data)->with(['images'])->paginate(5);
            // Добавляем параметры запроса к URL
            $FilmDataBase->appends($data);
            $items =   FilmResource::collection($FilmDataBase);
            $response = [
                'current_page' => $FilmDataBase->currentPage(),
                'data' => $items->items(),
                'next_page_url' => $FilmDataBase->nextPageUrl(),
                'path' => $FilmDataBase->path(),
                'per_page' => $FilmDataBase->perPage(),
                'prev_page_url' => $FilmDataBase->previousPageUrl(),
                'to' => $FilmDataBase->lastItem(),
                'total' => $FilmDataBase->total(),
                'last_page' => $FilmDataBase->lastPage(),
            ];

            if ($FilmDataBase->isEmpty()) {
                $filmsAPI = FilmGetHttpClient::getFilms($data);
                return $filmsAPI;
            } else {
                foreach ($FilmDataBase as $film) {
                    $film->is_my_film = Film::IsMyFilm($film);
                }
                return $response;
            }
        } else
            return response()->json('нет данных');

    }

}
