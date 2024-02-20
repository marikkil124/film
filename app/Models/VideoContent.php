<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoContent extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function film()
    {
        return $this->belongsTo(Film::class);

    }

}
