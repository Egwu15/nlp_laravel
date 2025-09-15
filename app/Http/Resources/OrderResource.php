<?php

namespace App\Http\Resources;

use App\Filament\Resources\OrderRuleResource;
use App\Models\OrderRule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**@mixin OrderRule */
class OrderResource extends JsonResource
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
            'number' => $this->number,
            'court_rule' => RuleResource::collection($this->whenLoaded('rules')),
        ];
    }
}
