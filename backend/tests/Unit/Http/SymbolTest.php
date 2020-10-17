<?php

namespace Tests\Unit\Http;

use Tests\TestCase;

class SymbolTest extends TestCase {

    public function testCanGet() {
        $response = $this->call( 'GET', '/api/v1/symbol' );
        $this->assertEquals( 200, $response->getStatusCode() );
    }
}
