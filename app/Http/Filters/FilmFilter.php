<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class FilmFilter
{
    protected array $keys = [

        'title_eng',
        'title',
        'year',

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
    public function titleEng(Builder $query,$value)
    {
        $query->where('title_eng', 'ilike', "%{$value}%");
    }

    public function title(Builder $query,$value)
    {
        $query->where('title', 'ilike', "%{$value}%");
    }

    public function year(Builder $query,$value)
    {
        $query->where('year', $value);
    }

}
