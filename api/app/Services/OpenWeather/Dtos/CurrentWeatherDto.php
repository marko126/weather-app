<?php

namespace App\Services\OpenWeather\Dtos;

class CurrentWeatherDto
{
    /** @var WeatherDto[] */
    public array $weather;

    public MainInfoDto $main;

    public int $visibility;

    public WindDto $wind;

    public $rain;

    public $snow;

    public CloudDto $clouds;

    public SystemDto $sys;

    public int $timezone;

    public string $name;
}
