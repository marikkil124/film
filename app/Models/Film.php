<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function genre()
    {
        return $this->belongsToMany(Genre::class, 'genre_films', 'film_id', 'genre_id');
    }


    public function userLike()
    {
        return $this->belongsToMany(Profile::class, 'like_films', 'film_id', 'profile_id');
    }

    public function videoContent()
    {
        return $this->belongsTo(VideoContent::class);

    }

    protected function titleStr(): Attribute
    {
        return Attribute::make(
            get: fn($v) => $v . ucfirst('sa'),
            set: fn($v) => strtolower($v),
        );
    }

    public function scopeMyFilms()
    {

    }


}
