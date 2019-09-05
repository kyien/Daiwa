<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Debtors_listings extends JsonResource
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
          'Fullnames' => mb_strimwidth($this->Fullnames,0,5,'...'); // transform the data to 5 characters long

        ];
    }
}
