<?php

namespace App\Models\Traits;

use App\Http\Filters\ProfileFilter;
use Illuminate\Database\Eloquent\Builder;


trait HasFilter
{
    public function scopeFilter(Builder $builder, array $data)
    {

       $class=  'App\Http\Filters\\'.class_basename($this).'Filter';

       $filter = app()->make($class);
        return $filter->apply( $builder, $data);

    }
}
