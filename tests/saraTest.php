<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Http\Mock\Client;
use Sara\Client\ClientBuilder;

final class SaraTest extends TestCase
{
  public function testAuth(): void
  {
    $mockClient = new Client();

    $clientBuilder = new ClientBuilder($mockClient);
    $sara = new Sara($clientBuilder);

    $auth = $this->createMock('Sara\Client\Auth');
    $auth->method('auth')->willReturn(["access_token" => "test", "expires_in" => 3600, "token_type" => "Bearer"]);

    $sara->auth("API_KEY", "API_SECRET", "", $auth);

    $this->assertEquals($sara->getAccessToken(), "test");
  }
}
