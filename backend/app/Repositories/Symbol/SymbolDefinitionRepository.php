<?php

namespace App\Repositories\Symbol;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SymbolDefinitionRepository implements SymbolRepository {

    /**
     * @var Client
     */
    private $http_client;

    /**
     * The data endpoint.
     */
    const DATA_ENDPOINT = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';


    /**
     * SymbolDefinitionRepository constructor.
     *
     * @param Client $http_client
     */
    public function __construct( Client $http_client ) {
        $this->http_client = $http_client;
    }


    /**
     * Lists symbol definition.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function getAll() {
        try {
            $response = $this->http_client->request( 'GET', self::DATA_ENDPOINT );
        } catch ( GuzzleException $e ) {
            return [];
        }

        if ( 200 === $response->getStatusCode() ) {
            $parsed_response = json_decode( $response->getBody()->getContents() );

            return collect( $parsed_response )->map( static function ( $item ) {
                $object = new \stdClass();
                $object->symbol = $item->Symbol;
                $object->companyName = sprintf("%s - %s", $item->{'Company Name'}, $item->Symbol);
                return $object;
            } );
        }

        return [];
    }
}
