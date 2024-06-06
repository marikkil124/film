<?php

namespace App\Http\Controllers\admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\FilmRequest;
use App\Http\Resources\Film\FilmResource;
use App\Models\Film;
use App\Services\Admin\FilmService;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 123;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilmRequest $request)
    {
        $data = $request->validated();




        $film = FilmService::store($data);
        return FilmResource::make($film);
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        return FilmResource::make($film);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilmRequest $request, Film $film)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        //
    }
}
