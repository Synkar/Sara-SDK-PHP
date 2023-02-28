<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Http\Mock\Client;
use Sara\Client\ClientBuilder;

final class OperationsTest extends TestCase
{
  public function testOperationsList(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":[{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"operation1"},{"uuid":"91c22e14-0bc2-465a-a8d8-1f8ce5b3ba7b","name":"operation2"}]}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $operations = $sara->hivemind()->operations()->list();
    $this->assertEquals($operations, json_decode('{"data":[{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"operation1"},{"uuid":"91c22e14-0bc2-465a-a8d8-1f8ce5b3ba7b","name":"operation2"}]}', true));
  }

  public function testOperationsRetrieve(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"operation1"}}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $operation = $sara->hivemind()->operations()->retrieve("176663ab-aa08-4c60-a86d-88a4570f690c");
    $this->assertEquals($operation, json_decode('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"operation1"}}', true));
  }

  public function testOperationsCreate(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"operation1"}}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $operation = $sara->hivemind()->operations()->create([
      "name" => "operation1"
    ]);
    $this->assertEquals($operation, json_decode('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"operation1"}}', true));
  }

  public function testOperationsDelete(): void
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

    $operation = $sara->hivemind()->operations()->delete("176663ab-aa08-4c60-a86d-88a4570f690c");
    $this->assertEquals($operation, true);
  }

  public function testOperationsUpdate(): void
  {
    $mockClient = new Client();

    $response = $this->createMock('Psr\Http\Message\ResponseInterface');
    $responseBody = $this->createMock('Psr\Http\Message\StreamInterface');
    $response->method('getStatusCode')->willReturn(200);
    $response->method('getBody')->willReturn($responseBody);
    $responseBody->method('getContents')->willReturn('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"operation1"}}');

    $mockClient->addResponse($response);

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $operation = $sara->hivemind()->operations()->update("176663ab-aa08-4c60-a86d-88a4570f690c", [
      "name" => "operation1"
    ]);
    $this->assertEquals($operation, json_decode('{"data":{"uuid":"176663ab-aa08-4c60-a86d-88a4570f690c","name":"operation1"}}', true));
  }
}
