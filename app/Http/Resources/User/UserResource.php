<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Category\SportCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'email' => $this->email,
            'name' => $this->name,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'last_seen' => $this->last_seen,
            'is_online' => $this->is_online,
            'roles' => $this->roles->pluck('name'),
        ];
    }
}
