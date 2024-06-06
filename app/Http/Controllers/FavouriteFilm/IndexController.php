<?php

namespace App\Http\Controllers\FavouriteFilm;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavouriteFilm\IndexResource;
use App\Http\Resources\Film\FilmResource;
use App\Models\FavouriteFilm;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $favouriteFilms = auth()->user()->film;

        return FilmResource::collection($favouriteFilms);

    }


}
