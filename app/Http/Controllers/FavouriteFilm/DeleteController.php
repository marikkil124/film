<?php

namespace App\Http\Controllers\FavouriteFilm;

class DeleteController
{
    public function __invoke(string $id)
    {

        auth()->user()->film()->detach($id);
        return response()->json(['status'=>'ok']);


    }
}
