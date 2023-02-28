<?php

declare(strict_types=1);


namespace Sara\Client;

use Sara\Client\ResponseMediator;
use Sara\Client\ClientBuilder;
use Sara;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Error;


class Auth
{
  protected string $api_key;
  protected string $api_secret;
  protected string $scope;
  protected ClientBuilder $clientBuilder;

  public function __construct(string $api_key, string $api_secret, $scope = "", ClientBuilder $clientBuilder = null)
  {
    $this->api_key = $api_key;
    $this->api_secret = $api_secret;
    $this->scope = $scope;
    $this->clientBuilder = $clientBuilder ?: new ClientBuilder();
    if (!$clientBuilder) {
      $uriFactory = Psr17FactoryDiscovery::findUriFactory();
      $this->clientBuilder->addPlugin(new BaseUriPlugin($uriFactory->createUri('https://auth.sara.synkar.com/oauth2/token')));
    }
  }

  public function auth(): array
  {
    $sara = new Sara($this->clientBuilder);
    $url = "?client_id=" . $this->api_key;
    $body = [];
    if ($this->scope != "") {
      $body = [
        "grant_type" => "client_credentials",
        "scope" => $this->scope
      ];
    } else {
      $body = [
        "grant_type" => "client_credentials",
      ];
    }
    $auth = $this->api_key . ":" . $this->api_secret;
    $headers = [
      "Content-Type" => "application/x-www-form-urlencoded",
      "User-Agent" => "Sara-SDK-PHP",
      "Accept-Language" => "en-US",
      "Authorization" => "Basic " . base64_encode($auth)
    ];
    return ResponseMediator::getContent($sara->getHttpClient()->post($url, $headers, http_build_query($body)));
  }

  public function getApiKey(): string
  {
    return $this->api_key;
  }

  public function getApiSecret(): string
  {
    return $this->api_secret;
  }

  public function getScope(): string
  {
    return $this->scope;
  }
}
