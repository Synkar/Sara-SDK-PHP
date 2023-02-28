<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Http\Mock\Client;
use Sara\Client\ClientBuilder;

final class RequestsTest extends TestCase
{
  public function testRequestsList(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":[{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"request1"},{"uuid":"91c22e14-0bc2-465a-a8d8-1f8ce5b3ba7b","name":"request2"}]}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $requests = $sara->hivemind()->requests()->list();
    $this->assertEquals($requests, json_decode('{"data":[{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"request1"},{"uuid":"91c22e14-0bc2-465a-a8d8-1f8ce5b3ba7b","name":"request2"}]}', true));
  }

  public function testRequestsRetrieve(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"request1"}}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $request = $sara->hivemind()->requests()->retrieve("176663ab-aa08-4c60-a86d-88a4570f690c");
    $this->assertEquals($request, json_decode('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"request1"}}', true));
  }

  public function testRequestsCreate(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"request1"}}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $request = $sara->hivemind()->requests()->create([
      "name" => "request1"
    ]);
    $this->assertEquals($request, json_decode('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"request1"}}', true));
  }
}
