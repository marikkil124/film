<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Profile extends Model
{
    use HasFactory;
    use HasFilter;

    protected $guarded = false;
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
