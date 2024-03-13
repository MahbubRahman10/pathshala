<?php

namespace App\Http\Resources\Test;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class TestResource extends JsonResource
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
            'TestName' => $this->name,
            'TestDate' => Carbon::parse($this->date)->format('Y-m-d')
            
        ];
    }
}
