<?php

namespace App\Http\Resources\Teacher;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
class TeacherCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $teachers = [];

        foreach($this->collection as $teacher) {

            array_push($teachers, [
                'id' => $teacher->id,
                'Username' => $teacher->username,
                'FirstName' => $teacher->firstname,
                'LastName' => $teacher->lastname
            ]);

        }
        return $teachers;
    }
}
