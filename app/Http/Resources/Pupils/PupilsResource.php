<?php

namespace App\Http\Resources\Pupils;

use Illuminate\Http\Resources\Json\JsonResource;

class PupilsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $grades = [];
        
        foreach($this->collection as $grade) {

            array_push($grades, [
                'Test Name' => $this->name,
                'Grade' => $this->grade
            ]);
        }
        return $grades;
    }
}
