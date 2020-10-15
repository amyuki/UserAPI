<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {

        if ($this->is_admin) {
            return array_merge(parent::toArray($request), ['is_admin' => true]);
        }
        return parent::toArray($request);
    }
}
