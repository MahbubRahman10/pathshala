<?php

namespace App\Http\Resources\Teacher;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
class TeacherSubjectCollection extends ResourceCollection
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
