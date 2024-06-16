<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Film extends Model
{
    use HasFactory;
    use HasFilter;

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

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function film()
    {
        return $this->belongsToMany(Film::class, 'favourite_films', 'film_id', 'user_id')->withPivot('estimate') ->withTimestamps();;
    }
    public function user()
    {
        return $this->belongsToMany(User::class, 'favourite_films', 'user_id', 'id')->withPivot('estimate') ->withTimestamps();;
    }

    public static function IsMyFilm($film)
    {
        $MyFilms = auth()->user()->film;

        if ($MyFilms->contains('id',$film->id)) {
            return true;
        } else
            return  false;

    }

}
