<?php

namespace App\Services\OpenWeather\Transformers;

use App\Services\Dtos\ForecastDto;
use App\Services\OpenWeather\Dtos\CurrentWeatherDto;
use App\Services\ResponseTransformerInterface;
use App\Services\WindDirectionTransformer;

class CurrentWeatherTransformer implements ResponseTransformerInterface
{
    public static function transform(CurrentWeatherDto|\stdClass $dto): ForecastDto
    {
        $result = new ForecastDto();

        $result->temperature = (int)$dto->main->temp;
        $result->temperatureFeeling = (int)$dto->main->feels_like;
        $result->description = $dto->weather[0]->main;
        $result->icon = $dto->weather[0]->icon;
        $result->humidity = (int)$dto->main->humidity;
        $result->pressure = (int)$dto->main->pressure;
        $result->windSpeed = (int)$dto->wind->speed;
        $result->windGust = (int)$dto->wind->gust;
        $result->windDirection = WindDirectionTransformer::transform($dto->wind->deg);
        $result->cloudCover = (int)$dto->clouds->all;
        $result->rainOneHour = isset($dto->rain) && isset($dto->rain->{'1h'}) ? (int)$dto->rain->{'1h'} : null;
        $result->rainTreeHours = isset($dto->rain) && isset($dto->rain->{'3h'}) ? (int)$dto->rain->{'3h'} : null;
        $result->snowOneHour = isset($dto->snow) && isset($dto->snow->{'1h'}) ? (int)$dto->snow->{'1h'} : null;
        $result->snowTreeHours = isset($dto->rain) && isset($dto->snow->{'3h'}) ? (int)$dto->snow->{'3h'} : null;
        $result->city = $dto->name;
        $result->country = $dto->sys->country ?? 'N/A';
        $result->timezone = $dto->timezone;

        return $result;
    }
}
