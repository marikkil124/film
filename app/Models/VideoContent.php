<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoContent extends Model
{
    use HasFactory;

    protected $guarded = false;
    const FILM=1;
    const SERIAL=2;
    const CARTOON=3;
    const ANIME=4;
    const ANIMATED_SERIES=5;


    //Названия по апи
    const getType = [
        self::FILM=>'movie',
        self::SERIAL=>'tv-series',
        self::CARTOON=>'cartoon',
        self::ANIME=>'anime',
        self::ANIMATED_SERIES=>'animated-series',


    ];
    public function film()
    {
        return $this->belongsTo(Film::class);

    }

}
