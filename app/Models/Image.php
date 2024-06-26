<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $guarded = false;
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
    CONST NOT_FOUND_IMAGE='https://oldestatehotel.com/files/oldestate/image/no_product.jpg';

}
