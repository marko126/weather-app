<?php

namespace Tests\Feature\Api;

use App\Models\Forecast;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForecastControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_today()
    {
        /** @var Forecast $forecast */
        $forecast = Forecast::factory()->has(User::factory())->create();

        $response = $this->get('/weather/today/' . $forecast->user_id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $forecast->id,
            'user_id' => $forecast->user_id,
        ]);
    }
}
