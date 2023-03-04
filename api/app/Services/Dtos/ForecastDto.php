<?php

namespace App\Services\Dtos;

use JsonSerializable;

class ForecastDto extends DataTransferObject implements JsonSerializable
{
    public int $temperature;

    public int $temperatureFeeling;

    public string $description;

    public int $pressure;

    public int $humidity;

    public int $windSpeed;

    public int $windGust;

    public string $windDirection;

    public int $cloudCover;

    public int $rainOneHour;

    public int $rainTreeHours;

    public int $snowOneHour;

    public int $snowTreeHours;

    public string $city;

    public string $country;

    public string $timezone;
}
