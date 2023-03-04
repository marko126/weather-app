<?php

namespace App\Providers;

use App\Services\ForecastInterface;
use App\Services\OpenWeather\OpenWeatherForecastService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(ForecastInterface::class, new OpenWeatherForecastService(
            new Client([
                'base_uri' => config('services.open_weather.api_url')
            ])
        ));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
