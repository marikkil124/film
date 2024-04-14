<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class References extends Controller
{
    public function productCount()
    {
            return response()->json(['count'=>auth()->user()->productInCart()->count()]);
    }


}
