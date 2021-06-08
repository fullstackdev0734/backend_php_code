<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Services\WeatherServices;
use App\Http\HttpCode;
use Illuminate\Support\Facades\Validator;

class WeatherinfoController extends Controller
{

    protected $weatherServices;

    public function __construct(WeatherServices $weatherServices) {
        $this->weatherServices = $weatherServices;
    }

    /**
    * Get Weather Data
    * @param $request
    * @return JSON 
    */
    public function getWeatherData(Request $request)
    {
        // Receive and validate the request data
        $city = $request['city'];
        $required['city'] = 'required|string';
        $validator = Validator::make($request->all(), $required);
        if ($validator->fails($validator)) {
            return response()->json(['message' => $validator->errors()], HttpCode::BAD_REQUEST);
        }

        // Return the weather info from Cache (If previously searched for the same city)
        $redisKeyName = str_replace(' ', '', strtolower($city));
        if (Redis::get("getDataForCity_" . $redisKeyName)) {
            return json_decode(Redis::get("getDataForCity_" . $redisKeyName), true);
        }

        // Fetch the weather info based on city
        $result = $this->weatherServices->getWeatherDataUsingCityName($city);
        $result = json_decode($result, true);

        // Store the weather info in cache for later use
        if (!isset($result['error']) && empty($result['error'])) {
            $result['current_time'] = time();
            $result = json_encode($result, true);
            Redis::set("getDataForCity_" . $redisKeyName, json_encode($result), 'EX', 3600);
        }
        return $result;
    }
}
