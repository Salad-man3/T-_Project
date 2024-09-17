<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'activity_date' => $this->activity_date,
            'description' => $this->description,
            'activity_type_id' => $this->activity_type_id,
            'activity_type' => new ActivityTypeResource($this->whenLoaded('activityType')),
            'photos' => $this->whenLoaded('photos', function () {
                return $this->photos->pluck('photo_url');
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
