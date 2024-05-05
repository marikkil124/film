<?php

namespace App\Http\Controllers\FavouriteFilm;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavouriteFilm\IndexResource;
use App\Models\FavouriteFilm;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        $favouriteFilms = FavouriteFilm::all();
        return IndexResource::collection($favouriteFilms);

    }


}
