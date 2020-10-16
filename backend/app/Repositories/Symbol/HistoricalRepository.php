<?php

namespace App\Repositories\Symbol;

use App\HistoricalFactory;
use GuzzleHttp\Client;

class HistoricalRepository implements SymbolRepository {

    private $http_client;

    public function __construct( Client $http_client) {

        $this->http_client = $http_client;
    }

    private function fetchData($query = []) {
        return $this->http_client->request('GET', env( "RAPID_API_ENDPOINT" ), [
            'headers' => [
                'x-rapidapi-host' => env( 'RAPID_API_HOST' ),
                'x-rapidapi-key' => env( 'RAPID_API_KEY' ),
                'useQueryString' => 'true',
                'Content-Type' => 'application/json',
            ],
            'query' => $query
        ]);
    }

    public function getInRange( $symbol, $start_date, $end_date ) {
        $response = $this->fetchData([
            'period1' => $start_date,
            'period2' => $end_date,
            'symbol' => $symbol,
            'frequency' => '1d',
            'filter' => 'history',
        ]);

        if(200 === $response->getStatusCode()) {
            return $response->getBody()->getContents();
        }

        return ['message' => 'error'];
    }
}
