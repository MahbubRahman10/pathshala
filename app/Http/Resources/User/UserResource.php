<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\User;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'UserId' => $this->userid,
            'UserName' => $this->username,
            'FirstName' => $this->firstname,
            'LastName' => $this->lastname,
            'JoinDate' => Carbon::parse($this->created_at)->format('M-d-Y'),
            
        ];
    }
}
