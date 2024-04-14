<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProfileFilter
{
    protected array $keys = [

        'firstname',
        'surname',
        'nickname',
        'gender',
        'phone',
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
    public function firstname(Builder $query,$value)
    {
        $query->where('firstname', 'ilike', "%{$value}%");
    }

    public function surname(Builder $query,$value)
    {
        $query->where('surname', 'ilike', "%{$value}%");
    }

    public function nickname(Builder $query,$value)
    {
        $query->where('nickname', 'ilike', "%{$value}%");
    }

    public function gender(Builder $query,$value)
    {
        $query->where('gender', 'ilike', "%{$value}%");
    }

    public function phone(Builder $query,$value)
    {
        $query->where('phone', 'ilike', "%{$value}%");
    }


}
