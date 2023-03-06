<?php

namespace App\Listeners;

use App\Events\CreateCurrentForecastEvent;
use App\Http\Resources\ForecastResource;
use App\Models\Forecast;
use App\Services\ForecastInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class CreateForecastModelListener implements ShouldQueue
{
    use InteractsWithQueue;

    public ForecastInterface $forecastService;

    /**
     * Create the event listener.
     */
    public function __construct(ForecastInterface $forecastService)
    {
        $this->forecastService = $forecastService;
    }

    /**
     * Handle the event.
     */
    public function handle(CreateCurrentForecastEvent $event): void
    {
        $forecast = $event->user->forecast;

        if (!$forecast) {
            $forecast = new Forecast(['user_id' => $event->user->id]);
        }

        $forecast->data = json_encode($this->forecastService->todayWeather($event->user));
        $forecast->save();

        Cache::put("forecast_user_{$event->user->id}", new ForecastResource($forecast->load('user')));
    }
}
