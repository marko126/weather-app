<?php

namespace App\Services\OpenWeather;

use App\Models\User;
use App\Services\Dtos\ForecastDto;
use App\Services\ForecastInterface;
use App\Services\OpenWeather\Dtos\CurrentWeatherDto;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use stdClass;

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
     * @return ForecastDto|ForecastDto[]
     */
    public function todayWeather(?User $user = null): ForecastDto|array
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

    private function getTodayWeatherForSingleUser(User $user): ForecastDto
    {
        try {
            $response = $this->client->get('weather', [
                'query' => [
                    'lat' => $user->latitude,
                    'lon' => $user->longitude,
                    'appId' => config('services.open_weather.api_key')
                ]
            ]);

            /** @var CurrentWeatherDto $data */
            $data = json_decode($response->getBody());

            return $this->transformDtoToResponse($data);
        } catch (GuzzleException|Exception $e) {
            Log::error(__METHOD__ . ': ' . $e->getMessage());

            throw $e;
        }
    }

    protected function transformDtoToResponse(CurrentWeatherDto|stdClass $dto): ForecastDto
    {
        $result = new ForecastDto();

        $result->temperature = $dto->main->temp;

        return $result;
    }
}
