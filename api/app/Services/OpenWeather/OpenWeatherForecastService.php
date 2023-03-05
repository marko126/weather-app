<?php

namespace App\Services\OpenWeather;

use App\Models\User;
use App\Services\Dtos\ForecastDto;
use App\Services\ForecastInterface;
use App\Services\OpenWeather\Dtos\CurrentWeatherDto;
use App\Services\OpenWeather\Transformers\CurrentWeatherTransformer;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OpenWeatherForecastService implements ForecastInterface
{
    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param User|null $user
     * @return ForecastDto|ForecastDto[]|null
     */
    public function todayWeather(?User $user = null): ForecastDto|array|null
    {
        if ($user) {
            return $this->getTodayWeatherForSingleUser($user);
        }

        $result = [];

        foreach (User::all() as $user) {
            $result[] = $this->getTodayWeatherForSingleUser($user);
        }

        return $result;
    }

    private function getTodayWeatherForSingleUser(User $user): ?ForecastDto
    {
        try {
            $response = $this->client->get('weather', [
                'query' => [
                    'lat' => $user->latitude,
                    'lon' => $user->longitude,
                    'appId' => config('services.open_weather.api_key'),
                    'units' => 'metric',
                ]
            ]);

            /** @var CurrentWeatherDto $data */
            $data = json_decode($response->getBody());

            return CurrentWeatherTransformer::transform($data);
        } catch (GuzzleException|Exception $e) {
            Log::error(__METHOD__ . ': ' . $e->getMessage());

            return null;
        }
    }
}
