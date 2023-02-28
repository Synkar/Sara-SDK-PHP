<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Http\Mock\Client;
use Sara\Client\ClientBuilder;

final class LocalitiesTest extends TestCase
{
  public function testLocalitiesList(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":[{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"locality1"},{"uuid":"91c22e14-0bc2-465a-a8d8-1f8ce5b3ba7b","name":"locality2"}]}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $localities = $sara->hivemind()->localities()->list();
    $this->assertEquals($localities, json_decode('{"data":[{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"locality1"},{"uuid":"91c22e14-0bc2-465a-a8d8-1f8ce5b3ba7b","name":"locality2"}]}', true));
  }

  public function testLocalitiesRetrieve(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"locality1"}}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $locality = $sara->hivemind()->localities()->retrieve("176663ab-aa08-4c60-a86d-88a4570f690c");
    $this->assertEquals($locality, json_decode('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"locality1"}}', true));
  }

  public function testLocalitiesCreate(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"locality1"}}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $locality = $sara->hivemind()->localities()->create([
      "name" => "locality1"
    ]);
    $this->assertEquals($locality, json_decode('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"locality1"}}', true));
  }

  public function testLocalitiesDelete(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(204);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $locality = $sara->hivemind()->localities()->delete("176663ab-aa08-4c60-a86d-88a4570f690c");
    $this->assertEquals($locality, true);
  }

  public function testLocalitiesUpdate(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"locality1"}}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $locality = $sara->hivemind()->localities()->update("176663ab-aa08-4c60-a86d-88a4570f690c", [
      "name" => "locality1"
    ]);
    $this->assertEquals($locality, json_decode('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"locality1"}}', true));
  }
}
