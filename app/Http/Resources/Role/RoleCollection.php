<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $roles = [];

        foreach($this->collection as $role) {

            array_push($roles, [
                'roleid' => $role->id,
                'href' => [
                    'link' => route('roles.show',$role->id)
                ]
            ]);

        }
        return $roles;
    }
}
