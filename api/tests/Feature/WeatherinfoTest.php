<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherinfoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_with_city_name()
    {
        $response = $this->getJson('api/weather_info?city=Ambala');

        $response->assertStatus(200);
    }

    public function test_without_city_name()
    {
        $response = $this->getJson('api/weather_info');

        $response->assertStatus(400);
    }

    
    public function test_with_incorrect_city_name()
    {
        $response = $this->getJson('api/weather_info?city=abc@gmail.com');

        $response->assertStatus(200);
    }
}
