<?php

namespace App\Services;

use App\Models\User;
use App\Services\Dtos\ForecastDto;

interface ForecastInterface
{
    /**
     * @param User|null $user
     * @return ForecastDto|array|null
     */
    public function todayWeather(?User $user = null): ForecastDto|array|null;
}
