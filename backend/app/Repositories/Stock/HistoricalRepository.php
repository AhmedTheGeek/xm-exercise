<?php

namespace App\Repositories\Stock;

use GuzzleHttp\Client;

class HistoricalRepository implements StockRepository {

    /**
     * @var Client
     */
    private $http_client;


    /**
     * HistoricalRepository constructor.
     *
     * @param Client $http_client
     */
    public function __construct( Client $http_client ) {

        $this->http_client = $http_client;
    }


    /**
     * Fetches the historical symbol data from the rapid hub endpoint
     *
     * @param array $query
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function fetchData( $query = [] ) {
        return $this->http_client->request( 'GET', env( "RAPID_API_ENDPOINT" ), [
            'headers' => [
                'x-rapidapi-host' => env( 'RAPID_API_HOST' ),
                'x-rapidapi-key' => env( 'RAPID_API_KEY' ),
                'useQueryString' => 'true',
                'Content-Type' => 'application/json',
            ],
            'query' => $query,
        ] );
    }


    /**
     * @param string $symbol The symbol name
     * @param int $start_date The query start date
     * @param int $end_date The query end date
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInRange( $symbol, $start_date, $end_date ) {
        $response = $this->fetchData( [
            'period1' => $start_date,
            'period2' => $end_date,
            'symbol' => $symbol,
            'frequency' => '1d',
            'filter' => 'history',
        ] );
        if ( 200 === $response->getStatusCode() ) {
            $content = json_decode( $response->getBody()->getContents() );
            if ( is_object($content) && property_exists( $content, 'prices' ) ) {
                return $content->prices;
            }
        }

        return [];
    }
}
