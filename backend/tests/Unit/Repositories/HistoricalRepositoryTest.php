<?php

namespace Tests\Unit\Http;

use App\Repositories\Stock\HistoricalRepository;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;

class HistoricalRepositoryTest extends TestCase {

    public function testCanGetInRange() {
        $http_client_stub = $this->createMock( Client::class );
        $response_stub = $this->createMock( ResponseInterface::class );
        $response_body_stub = $this->createMock( StreamInterface::class );

        $response_stub->method( 'getStatusCode' )->willReturn( 200 );
        $response_stub->method( 'getBody' )->willReturn( $response_body_stub );
        $response_body_stub->method( 'getContents' )
            ->willReturn( '{"prices":[{"date":1602077400,"open":114.62000274658203,"high":115.55000305175781,"low":114.12999725341797,"close":115.08000183105469,"volume":96849000,"adjclose":115.08000183105469}]}' );
        $http_client_stub->method( 'request' )->willReturn( $response_stub );

        $subject = new HistoricalRepository( $http_client_stub );
        $result = $subject->getInRange( 'APPL', time(), time() );
        $this->assertNotEmpty( $result );
    }


    public function testWillReturnEmptyIfRequestFails() {
        $http_client_stub = $this->createMock( Client::class );
        $response_stub = $this->createMock( ResponseInterface::class );

        $response_stub->method( 'getStatusCode' )->willReturn( 400 );
        $http_client_stub->method( 'request' )->willReturn( $response_stub );

        $subject = new HistoricalRepository( $http_client_stub );
        $result = $subject->getInRange( 'APPL', time(), time() );
        $this->assertEmpty( $result );
    }
}
