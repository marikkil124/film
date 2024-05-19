<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $guarded = false;


    public function film()
    {
        return $this->belongsToMany(Film::class, 'genre_films', 'genre_id','film_id');
    }
}
