<?php

namespace App\Http\Resources\Film;

use App\Http\Resources\Genre\GenreResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->title,
            'title_eng'=>$this->title_eng,
            'genres'=>GenreResource::collection($this->genre),
            'year'=>$this->year,
            'type'=>$this->videocontent->title,
            'url'=>Image::where('imageable_id',$this->id)->pluck('path')->first(),
            'film_id_api'=>$this->film_id_api,
            'type_number'=>$this->videocontent->type_number??null,
            'video_content'=>$this->videocontent,
            'is_my_film'=>$this->is_my_film??null,
            'description'=>$this->description,
            'id'=>$this->id,


        ];
    }
}
