<?php

namespace App\Http\Resources\Classes;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'Class Code' => $this->classcode,
            'Class Name' => $this->classname
        ];
    }
}
