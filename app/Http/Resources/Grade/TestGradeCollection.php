<?php

namespace App\Http\Resources\Grade;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TestGradeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
