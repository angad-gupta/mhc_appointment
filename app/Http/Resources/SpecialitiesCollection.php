<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SpecialitiesCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'links' => [
                'self' => route("api.department",$this->slug),
            ],
            'status' => $this->status,
            'photo' => asset($this->photo),
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
