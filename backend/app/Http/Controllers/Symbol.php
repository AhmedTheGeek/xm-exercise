<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Symbol extends Controller {

    public function get() {
        try {
            $response = ( new Client() )->request( 'GET', 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json' );
            $json = json_decode( $response->getBody()->getContents() );

            return collect( $json )->map( static function ( $item ) {
                $object = new \stdClass();
                $object->symbol = $item->Symbol;
                $object->companyName = sprintf("%s - %s", $item->{'Company Name'}, $item->Symbol);
                return $object;
            } );
        } catch ( GuzzleException $e ) {
            return [];
        }
    }
}
