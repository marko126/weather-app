<?php

namespace App\Services;

use App\Enums\WindDirectionEnum;

class WindDirectionTransformer
{
    public static function transform(int $degrees): string
    {
        if ($degrees < 24 || $degrees > 336) {
            return WindDirectionEnum::North->value;
        }

        if ($degrees < 69) {
            return WindDirectionEnum::Northeast->value;
        }

        if ($degrees < 114) {
            return  WindDirectionEnum::East->value;
        }

        if ($degrees < 159) {
            return  WindDirectionEnum::Southeast->value;
        }

        if ($degrees < 204) {
            return  WindDirectionEnum::South->value;
        }

        if ($degrees < 249) {
            return  WindDirectionEnum::Southwest->value;
        }

        if ($degrees < 294) {
            return  WindDirectionEnum::West->value;
        }

        return WindDirectionEnum::Northwest->value;
    }
}
