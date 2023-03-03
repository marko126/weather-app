<?php

namespace App\Services\OpenWeather\Dtos;

class MainInfoDto
{
    public int|float $temp;

    public int|float $feels_like;

    public int|float $temp_min;

    public int|float $temp_max;

    public int|float $pressure;

    public int|float $humidity;

    public int|float $sea_level;

    public int|float $grnd_level;
}
