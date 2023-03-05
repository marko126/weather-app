<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

/**
 * Class UserResource
 *
 * @mixin User
 *
 * @package App\Http\Resources
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'forecast' => $this->whenLoaded('forecast', function () {
                return new ForecastResource($this->forecast);
            }),
        ];
    }
}
