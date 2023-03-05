<?php

namespace Tests\Feature\Api;

use App\Models\Forecast;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        User::factory()->has(Forecast::factory())->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'longitude' => '17.07683100',
            'latitude' => '-15.38989300',
        ]);
        User::factory()->has(Forecast::factory())->count(5)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertJsonCount(6);
        $response->assertJsonFragment([
            'id' => 1,
            'name' => 'Test',
            'email' => 'test@example.com',
            'longitude' => '17.07683100',
            'latitude' => '-15.38989300',
        ]);
    }
}
