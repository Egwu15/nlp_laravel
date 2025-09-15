<?php

namespace App\Http\Resources;

use App\Models\CourtRule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin  CourtRule */
class CourtRuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_free' => $this->is_free,
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }
}
