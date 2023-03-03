<?php

namespace App\Services\OpenWeather\Dtos;

class WindDto
{
    public int|float $speed;

    public int $deg;

    public int|float $gust;
}
