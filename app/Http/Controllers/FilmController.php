<?php

namespace App\Http\Controllers;



use App\Http\HttpClients\Film\FilmGetHttpClient;
use App\Http\Requests\Film\IndexRequest;
use App\Models\Film;
use App\Models\Product;
use App\Services\FilmService;

class FilmController extends Controller
{

    public function index(IndexRequest $request)
    {
        $data = $request->validated();

        $FilmDataBase = Film::filter($data)->with(['images']);
        dd($FilmDataBase);

       $filmsAPI=   FilmGetHttpClient::getFilms();



        return $filmsAPI;
    }




}
