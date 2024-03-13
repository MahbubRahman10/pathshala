<?php

namespace App\Http\Resources\Grade;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GradeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $grades = [];

        foreach($this->collection as $grade) {

            array_push($grades, [
                'Pupil Firt Name' => $grade->firstname,
                'Pupil Last Name' => $grade->lastname,
                'Subject Name' => $grade->subjectname,
                'Test Name' => $grade->name,
                'Grade' => $grade->grade
            ]);
        }
        return $grades;
    }
}
