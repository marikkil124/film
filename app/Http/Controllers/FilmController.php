<?php

namespace App\Http\Controllers;


use App\Http\HttpClients\Film\FilmGetHttpClient;
use App\Http\Requests\Film\IndexRequest;
use App\Http\Requests\Film\StoreRequest;
use App\Http\Resources\Film\FilmResource;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Image;
use App\Models\VideoContent;
use App\Services\FilmService;


class FilmController extends Controller
{

    public function index(IndexRequest $request)
    {
        $data = $request->validated();

       return FilmService::index($data);

    }

    public function store(StoreRequest $request)
    {

        $data = $request->validated();

        $genres = Genre::all();

        return  FilmService::store($data, $genres);

    }







}
