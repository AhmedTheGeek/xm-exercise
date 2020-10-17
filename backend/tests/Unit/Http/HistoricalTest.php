<?php

namespace Tests\Unit\Http;

use Tests\TestCase;

class HistoricalTest extends TestCase
{


    public function testCannotGetWithNoData() {
        $response = $this->call('GET', '/api/v1/historical');
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testCannotGetWithInvalidData() {
        $response = $this->call('GET', '/api/v1/historical', [
            'email' => 'invalid@email',
            'symbol' => 'AAADDD',
            'startDate' => 'string',
            'endDate' => '1602107520',
            'companyName' => 'correct'
        ]);

        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testCanGet() {
        $response = $this->call('GET', '/api/v1/historical', [
            'email' => 'email@provider.tld',
            'symbol' => 'AAPL',
            'startDate' => '1601589120',
            'endDate' => '1602107520',
            'companyName' => 'Apple'
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
