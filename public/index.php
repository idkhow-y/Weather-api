<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;

header('Content-Type: application/json; charset=utf-8');

$cities = [
    'kyiv' => ['name' => 'Kyiv', 'lat' => 50.45, 'lon' => 30.52],
    'lviv' => ['name' => 'Lviv', 'lat' => 49.84, 'lon' => 24.03],
    'odesa' => ['name' => 'Odesa', 'lat' => 46.48, 'lon' => 30.73]
];

$city = strtolower($_GET['city'] ?? 'kyiv');

if (!isset($cities[$city])) {
    http_response_code(400);

    echo json_encode([
        'error' => 'Unknown city',
        'available_cities' => array_keys($cities)
    ]);

    exit;
}

$selectedCity = $cities[$city];

// Створюємо HTTP-клієнт
$client = new Client([
    'timeout' => 10
]);

$url = 'https://api.open-meteo.com/v1/forecast';

try {
    $response = $client->get($url, [
        'query' => [
            'latitude' => $selectedCity['lat'],
            'longitude' => $selectedCity['lon'],
            'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m'
        ]
    ]);

    $weather = json_decode($response->getBody()->getContents(), true);

    $data = [
        'city' => $selectedCity['name'],
        'temperature' => $weather['current']['temperature_2m'],
        'humidity' => $weather['current']['relative_humidity_2m'],
        'wind_speed' => $weather['current']['wind_speed_10m']
    ];

    echo json_encode($data, JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    error_log($e->getMessage());

    http_response_code(502);

    echo json_encode([
        'error' => 'Unable to fetch weather data'
    ], JSON_PRETTY_PRINT);
}