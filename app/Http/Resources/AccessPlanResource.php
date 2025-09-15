<?php

namespace App\Http\Resources;

use App\Models\AccessPlan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**@mixin  AccessPlan */
class AccessPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
            'price' => $this->price,
            'duration_days' => $this->duration_days,
            'discount_price' => $this->discount_price,
            'discount_expires_at' => $this->discount_expires_at,
            'google_product_id' => $this->google_product_id,
            'laws' => LawResource::collection($this->whenLoaded('laws')),
            'courtRules' => LawResource::collection($this->whenLoaded('courtRules')),
        ];
    }
}
