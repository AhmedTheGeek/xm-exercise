<?php

namespace Tests\Unit\Http;

use App\Repositories\Symbol\SymbolDefinitionRepository;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;
use GuzzleHttp\Exception\RequestException;

class SymbolDefinitionRepositoryTest extends TestCase {

    public function testCanGetAll() {
        $http_client_stub = $this->createMock( Client::class );
        $response_stub = $this->createMock( ResponseInterface::class );
        $response_body_stub = $this->createMock( StreamInterface::class );

        $response_stub->method( 'getStatusCode' )->willReturn( 200 );
        $response_stub->method( 'getBody' )->willReturn( $response_body_stub );
        $response_body_stub->method( 'getContents' )
            ->willReturn( '[{"Symbol":"AAIT","Company Name":"iShares MSCI All Country Asia Information Technology Index Fund - AAIT"}]' );
        $http_client_stub->method( 'request' )->willReturn( $response_stub );

        $subject = new SymbolDefinitionRepository( $http_client_stub );
        $result = $subject->getAll();
        $this->assertNotEmpty( $result );
    }

}
