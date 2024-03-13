<?php

namespace App\Http\Resources\Classespupils;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
class ClassespupilsCollection extends ResourceCollection
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
