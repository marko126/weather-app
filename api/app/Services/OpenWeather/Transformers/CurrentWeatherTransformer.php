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
        $result->humidity = (int)$dto->main->humidity;
        $result->pressure = (int)$dto->main->pressure;
        $result->windSpeed = (int)$dto->wind->speed;
        $result->windGust = (int)$dto->wind->gust;
        $result->windDirection = WindDirectionTransformer::transform($dto->wind->deg);
        $result->cloudCover = (int)$dto->clouds->all;
        $result->rainOneHour = isset($dto->rain) ? (int)$dto->rain->{'1h'} : null;
        $result->rainTreeHours = isset($dto->rain) ? (int)$dto->rain->{'3h'} : null;
        $result->snowOneHour = isset($dto->snow) ? (int)$dto->snow->{'1h'} : null;
        $result->snowTreeHours = isset($dto->rain) ? (int)$dto->snow->{'3h'} : null;
        $result->city = $dto->name;
        $result->country = $dto->sys->country;
        $result->timezone = $dto->timezone;

        return $result;
    }
}