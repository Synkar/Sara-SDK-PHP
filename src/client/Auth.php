<?php

declare(strict_types=1);


namespace Sara\Client;

use Sara\Client\ResponseMediator;
use Sara\Client\ClientBuilder;
use Sara;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Discovery\Psr17FactoryDiscovery;


final class Auth
{
  private string $api_key;
  private string $api_secret;
  private string $scope;

  public function __construct(string $api_key, string $api_secret, string $scope)
  {
    $this->api_key = $api_key;
    $this->api_secret = $api_secret;
    $this->scope = $scope;
  }

  public function auth(): array
  {
    $clientBuilder = new ClientBuilder();
    $uriFactory = Psr17FactoryDiscovery::findUriFactory();
    $clientBuilder->addPlugin(new BaseUriPlugin($uriFactory->createUri('https://auth.sara.synkar.com')));
    $sara = new Sara($clientBuilder);
    $url = "/login?client_id=" . $this->api_key;
    $body = [];
    if ($this->scope) {
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
      "Authorization" => "Basic" . base64_encode($auth)
    ];
    return ResponseMediator::getContent($sara->getHttpClient()->post($url, $headers, $body));
  }
}
