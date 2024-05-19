<?php

namespace App\Http\Controllers;


use App\Http\HttpClients\Film\FilmGetHttpClient;
use App\Http\Requests\Film\IndexRequest;
use App\Http\Requests\Film\StoreRequest;
use App\Http\Resources\Film\FilmResource;
use App\Models\FavouriteFilm;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Product;
use App\Models\VideoContent;
use App\Services\FilmService;
use Inertia\Inertia;


class FilmController extends Controller
{

    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        function containsCyrillic($str)
        {
            return preg_match('/[\p{Cyrillic}]/u', $str);
        }

        if (!containsCyrillic($data['title'])) {
            $data['title_eng'] = $data['title'];
            unset($data['title']);
        }

        if (isset($data['title']) or isset($data['title_eng'])) {
            $FilmDataBase = Film::filter($data)->with(['images'])->get();
            if ($FilmDataBase->isEmpty()) {
                $filmsAPI = FilmGetHttpClient::getFilms($data);
                return $filmsAPI;
            } else {
                return FilmResource::collection($FilmDataBase)->resolve();
            }
        } else
            return response()->json('нет данных');

    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        foreach ($data['genres'] as $genre) {
            foreach ($genre as $name) {
                Genre::updateOrCreate(
                    ['title' => $name]
                );

            }
        }
        VideoContent::updateOrCreate(
            ['title' => $data['type']]
        );

        $type = VideoContent::where('title', $data['type'])->pluck('id')->first();

        $film = Film::updateOrCreate([
            'title' => $data['title'],
            'title_eng' => $data['title_eng'],
            'year' => $data['year'],
            'video_content_id' => $type,
        ]);


        foreach ($data['genres'] as $genre) {
            foreach ($genre as $name) {

                $genreId = Genre::where('title', $name)->pluck('id')->first();
                $film->genre()->attach($genreId);
            }
        }


        Image::create([
            'path' => $data['url'],
            'imageable_id' => $film->id,
            'imageable_type' => Film::class
        ]);


    }


}
