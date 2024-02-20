<?php

namespace App\Http\Resources\Film;

use App\Http\Resources\Genre\GenreResource;
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
            'video_content_title'=>$this->videoContent->title,
            'genres'=>GenreResource::collection($this->genre),
            'rating'=>$this->rating
        ];
    }
}
