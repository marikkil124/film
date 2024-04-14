<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductFilter
{
    protected array $keys = [

        'price',
        'description',

    ];

    public function apply(Builder $builder,array $data):Builder
    {

        foreach ($this->keys as $key)
        {
            if (isset($data[$key]) && method_exists($this, $method = Str::camel($key)))
            {
                $this->$method($builder,$data[$key]);
            }

        }
        return $builder;
    }
    public function price(Builder $query,$value)
    {
        $query->where('price', 'ilike', "%{$value}%");
    }

    public function description(Builder $query,$value)
    {
        $query->where('description', 'ilike', "%{$value}%");
    }



}
