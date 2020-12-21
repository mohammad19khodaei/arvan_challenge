<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WinnerResource extends JsonResource
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
            'phone' => $this->phone,
            'code' => $this->code,
        ];
    }
}
