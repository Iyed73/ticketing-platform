<?php

use Shieldon\SimpleCache\Cache;




class CurrencyConverter {
    private const URL = "https://api.freecurrencyapi.com/v1/latest";

    private $apiKey;

    public function __construct() {
        $this->apiKey = $_ENV['CURRENCY_CONVERTER_API_KEY'];
    }

    private function getCacheInstance() {
        $config = [
            'host'    => $_ENV['DB_SERVERNAME'],
            'port'    => 3306,
            'user'    => $_ENV["DB_USERNAME"],
            'pass'    => $_ENV['DB_PASSWORD'],
            'dbname'  => $_ENV['DATABASE_NAME'],
            'table'   => 'cache_data',
            'charset' => 'utf8mb4'
        ];
        $cache = new Cache('mysql', $config);
        $cache->rebuild();
        return $cache;
    }

    private function requestData() {
        $url = self::URL . "?apikey=" . $this->apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return $data['data'];
    }

    private function getData() {
        $cache = $this->getCacheInstance();
        $cacheKey = 'currency';
        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        } else {
            $data = $this->requestData();
            // Cache for 3600 seconds.
            $cache->set($cacheKey, $data, 3600);
            return $data;
        }
    }

    public function convertPrice($value, $currency) {
        $conversionData = $this->getData();
        $convertedValue = $value * ($conversionData[$currency] ?? 1);
        return (float)number_format($convertedValue, 2, '.', '');
    }
}