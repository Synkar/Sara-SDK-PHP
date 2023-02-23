<?php

declare(strict_types=1);

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\UriFactory;
use Sara\Client\Auth;
use Sara\Client\ClientBuilder;
use Sara\HiveMind;

final class Sara
{
  private ClientBuilder $clientBuilder;
  private string $access_token;
  private string $expires_in;
  private string $token_type;

  public function __construct(ClientBuilder $clientBuilder = null, UriFactory $uriFactory = null)
  {
    $this->clientBuilder = $clientBuilder ?: new ClientBuilder();
    $uriFactory = $uriFactory ?: Psr17FactoryDiscovery::findUriFactory();

    $this->clientBuilder->addPlugin(
      new BaseUriPlugin($uriFactory->createUri('https://sara.synkar.com'))
    );
    $this->clientBuilder->addPlugin(
      new HeaderDefaultsPlugin(
        [
          'User-Agent' => 'Sara-SDK-PHP',
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
        ]
      )
    );
  }

  public function hivemind(): HiveMind
  {
    return new HiveMind($this);
  }

  public function auth(string $api_key, string $api_secret, string $scope): void
  {
    $auth = new Auth($api_key, $api_secret, $scope);
    $result = $auth->auth();
    $this->access_token = $result["access_token"];
    $this->expires_in = $result["expires_in"] + time();
    $this->token_type = $result["token_type"];
    $this->clientBuilder->addPlugin(new HeaderSetPlugin(
      [
        "Authorization" => $this->access_token
      ]
    ));
  }

  public function getHttpClient(): HttpMethodsClientInterface
  {
    return $this->clientBuilder->getHttpClient();
  }
}
