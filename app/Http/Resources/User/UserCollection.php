<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $users = [];

        foreach($this->collection as $user) {

            array_push($users, [
                'id' => $user->id,
                'Username' => $user->username,
                'FirstName' => $user->firstname,
                'LastName' => $user->lastname,
                'UserRole' => $user->roles->first()->name,
                'JoinDate' => Carbon::parse($user->created_at)->format('M d,Y')
            ]);

        }
        return $users;
    }
}
