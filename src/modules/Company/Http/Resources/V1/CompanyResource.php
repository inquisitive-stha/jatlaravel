<?php

namespace Modules\Company\Http\Resources\V1;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'type'        => 'company',
            'id'          => $this->id,
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'location' => $this->location,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => [
                'user' => $this->user_id ? [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id
                    ],
                    'links' => [
                        'self' => route('api.v1.users.show', ['user' => $this->user_id])
                    ]
                ] : null,
            ],
            'includes' => new UserResource($this->whenLoaded('user')),
            'links' => [
                'self' => route('api.v1.companies.show', ['company' => $this->id]),
            ],
        ];
    }
}
