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

                $MyFilms = auth()->user()->film;

                foreach ($FilmDataBase as $film) {
                    if ($MyFilms->contains('id', $film->id)) {
                        $film->is_my_film = 'my';
                    } else
                        $film->is_my_film = 'mo';
                }

                return FilmResource::collection($FilmDataBase)->resolve();
            }
        } else
            return response()->json('нет данных');

    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $genres = Genre::all();
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

        $film = Film::updateOrCreate([
            'title' => $data['title'],
            'title_eng' => $data['title_eng'],
            'year' => $data['year'],
            'video_content_id' => $data['type_number'] ?? null,
        ]);


        $film->genre()->sync($genreIds);


        Image::updateOrcreate([
            'path' => $data['url'],
            'imageable_id' => $film->id,
            'imageable_type' => Film::class
        ]);

        auth()->user()->film()->attach($film->id);

        return response()->json([
            '213' => 'asd',

        ]);

    }


}
