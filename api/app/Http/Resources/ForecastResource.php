<?php

namespace App\Http\Resources;

use App\Models\Forecast;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ForecastResource
 *
 * @mixin Forecast
 *
 * @package App\Http\Resources
 */
class ForecastResource extends JsonResource
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
            'data' => json_decode($this->data),
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
        ];
    }
}
