<?php

namespace App\Http\Controllers;

use App\Http\Resources\ForecastResource;
use App\Models\Forecast;
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
            return $this->respond(Cache::get("forecast_user_$id"));
        }

        if ($user->forecast) {
            return $this->respond(new ForecastResource($user->forecast->load('user')));
        }

        $forecastData = $service->todayWeather($user);

        if (empty($forecastData)) {
            return $this->respondError();
        }

        $forecast = new Forecast();
        $forecast->user_id = $id;
        $forecast->data = json_encode($forecastData);
        $forecast->save();

        $forecastResource = new ForecastResource($forecast->load('user'));

        Cache::put("forecast_user_$id", $forecastResource);

        return $this->respond($forecastResource);
    }
}
