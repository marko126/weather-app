<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\Dtos\ForecastDto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class ForecastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'data' => json_encode($this->getDto()),
            'user_id' => User::factory(),
        ];
    }

    public function getDto(): string
    {
        $result = new ForecastDto();

        $result->temperature = rand(-15, 35);
        $result->temperatureFeeling = rand(-15, 35);
        $result->description = 'Rain';
        $result->icon = '10n';
        $result->humidity = rand(1, 99);
        $result->pressure = rand(100, 1000);
        $result->windSpeed = rand(0, 30);
        $result->windGust = rand(0, 50);
        $result->windDirection = 'E';
        $result->cloudCover = rand(1, 99);
        $result->rainOneHour = rand(0, 50);
        $result->rainTreeHours = rand(0, 150);
        $result->snowOneHour = rand(0, 50);
        $result->snowTreeHours = rand(0, 150);
        $result->city = $this->faker->city;
        $result->country = $this->faker->countryCode;
        $result->timezone = $this->faker->timezone;

        return json_encode($result);
    }
}
