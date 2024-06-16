<?php

namespace App\Http\Controllers\FavouriteFilm;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavouriteFilm\StoreEstimateRequest;
use App\Http\Resources\FavouriteFilm\IndexResource;
use App\Http\Resources\Film\FilmResource;
use App\Models\FavouriteFilm;
use App\Models\Film;
use Illuminate\Http\Request;

class StoreEstimateController extends Controller
{
    public function __invoke(Film $film,StoreEstimateRequest $request)
    {
        $data = $request->validated();

       auth()->user()->film()->updateExistingPivot($film->id, ['estimate' => $data['estimate']]);


    }


}
