<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LearningSystemCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
                'id' => $this->id,
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'description_ar' => $this->description_ar,
                'description_en' => $this->description_en,
                'image' => $this->image,
                "remember_token" => $this->remember_token,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
                "deleted_at" => $this->deleted_at

        ];

    }
}
