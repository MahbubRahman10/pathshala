<?php

namespace App\Http\Resources\Classes;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
class PupilsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pupils = [];

        foreach($this->collection as $user) {
            array_push($pupils, [
                'id' => $user->user_id,
                'Username' => $user->username,
                'FirstName' => $user->firstname,
                'LastName' => $user->lastname
            ]);

        }
        return $pupils;
    }
}
