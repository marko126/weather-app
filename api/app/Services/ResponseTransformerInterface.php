<?php

namespace App\Services;

use App\Services\Dtos\ForecastDto;
use stdClass;

interface ResponseTransformerInterface
{
    /**
     * @param stdClass $dto
     * @return ForecastDto
     */
    public static function transform(stdClass $dto): ForecastDto;
}
