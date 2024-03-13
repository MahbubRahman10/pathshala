<?php

namespace App\Http\Resources\Classes;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $classes = [];

        foreach($this->collection as $class) {

            array_push($classes, [
                'id' => $class->id,
                'ClassCode' => $class->classcode,
                'ClassName' => $class->classname
            ]);

        }
        return $classes;
    }
}
