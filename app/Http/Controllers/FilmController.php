<?php

namespace App\Http\Controllers;



use App\Http\HttpClients\Film\FilmGetHttpClient;
use App\Http\Requests\Film\IndexRequest;
use App\Http\Resources\Film\FilmResource;
use App\Models\Film;
use App\Models\Product;
use App\Services\FilmService;
use Inertia\Inertia;


class FilmController extends Controller
{

    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        function containsCyrillic($str) {
            return preg_match('/[\p{Cyrillic}]/u', $str);
        }
          if (!containsCyrillic($data['title'])) {
          $data['title_eng']=$data['title'];
          unset($data['title']);
         }


        if (isset($data['title']) or isset($data['title_eng']))
        {
            $FilmDataBase = Film::filter($data)->with(['images'])->get();
            if ($FilmDataBase->isEmpty()) {
                $filmsAPI=   FilmGetHttpClient::getFilms($data);
                return $filmsAPI;
            }
            else
            {
                return FilmResource::collection($FilmDataBase);
            }
        }
           else
            return response()->json('нет данных');





    }



}
