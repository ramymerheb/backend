<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'id'        =>  $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'image'      => $this->image,
            'email_verified_at'      => Carbon::parse($this->email_verified_at)->toDayDateTimeString(),
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
        ];
    }
}
