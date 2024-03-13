<?php

namespace App\Http\Resources\Pupils;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PupilsTestCollection extends ResourceCollection
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

