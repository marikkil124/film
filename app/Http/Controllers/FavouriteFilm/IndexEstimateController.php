<?php

namespace App\Http\Controllers\FavouriteFilm;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavouriteFilm\IndexResource;
use App\Http\Resources\Film\FilmResource;
use App\Models\FavouriteFilm;
use Illuminate\Http\Request;

class IndexEstimateController extends Controller
{
    public function __invoke()
    {
        $favouriteFilms = auth()->user()->film;

        $estimates = collect();
        foreach ($favouriteFilms as $film)
        {
            $estimates ->push($film->pivot->estimate) ;
        }


        $count = $estimates->countBy();


        $count->all();
        $estimate = $estimates->unique();

        return response()->json(['count'=>$count,'estimate'=>$estimate]);




    }


}
