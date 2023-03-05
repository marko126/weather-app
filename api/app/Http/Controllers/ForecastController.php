<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ForecastInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ForecastController extends Controller
{
    public function today(int $id, ForecastInterface $service): JsonResponse
    {
        $user = User::findOrFail($id);

        if (Cache::has("forecast_user_$id")) {
            return $this->respond([
                'user' => new UserResource($user),
                'forecast' => Cache::get("forecast_user_$id")
            ]);
        }

        $forecastData = $service->todayWeather($user);

        if (empty($forecastData)) {
            return $this->respondError();
        }

        Cache::put("forecast_user_$id", $forecastData);

        return $this->respond([
            'user' => new UserResource($user),
            'forecast' => $forecastData,
        ]);
    }
}
