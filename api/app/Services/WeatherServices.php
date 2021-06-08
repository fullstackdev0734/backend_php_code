<?php
namespace App\Services;

class WeatherServices
{

    private $apiUrl = '';
    private $apiKey = '';
    private $apiVersion = '';
    
    /**
     * Get a constuctor
     */
    public function __construct()
    {
        $this->apiUrl = env('API_URL');
        $this->apiKey = env('API_KEY');
        $this->apiVersion = env('API_VERSION');
    }

    /**
     * Get Weather Data from API
     */
    public function getWeatherDataUsingCityName(string $city)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request(
                    'GET', 
                    $this->apiUrl . '/data/' . $this->apiVersion . '/weather',
                    [
                        'query' => [
                            'q' => $city,
                            'appid'=> $this->apiKey,
                            'units' => 'metric'
                        ]
                    ]
            );
            $result = $response->getBody()->getContents();
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), "404 Not Found")) {
                $result = json_encode(['error' => 'City not found']);
            }
            else {
                $result = json_encode(['error' => 'Something went wrong']);
            }
        }
        return $result;
    }
}