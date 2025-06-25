<?php

namespace App\Http\Resources;

use App\Models\Law;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**@mixin  Law */
class LawPartResource extends JsonResource
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
            'category' => $this->category->name,
            'is_free' => $this->is_free,
            'schedule' => ScheduleResource::collection($this->whenLoaded('schedule')),
            'chapter' => ChapterResource::collection($this->whenLoaded('chapters')),
        ];
    }
}
