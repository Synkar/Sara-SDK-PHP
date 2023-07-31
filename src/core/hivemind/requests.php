<?php

declare(strict_types=1);

namespace Sara\HiveMind;

use Sara\Client\ResponseMediator;
use Sara;

final class Requests
{
  private Sara $sara;
  private string $base_url = "/v1/hivemind/requests";

  public function __construct(Sara $sara)
  {
    $this->sara = $sara;
  }

  public function list(int $page = 1, int $limit = 10): array
  {
    $url = $this->base_url . "/?page=" . $page . "&limit=" . $limit;
    return ResponseMediator::getContent($this->sara->getHttpClient()->get($url));
  }
  public function retrieve(string $uuid): array
  {
    $url = $this->base_url . "/" . $uuid . "/";
    return ResponseMediator::getContent($this->sara->getHttpClient()->get($url));
  }
  public function create(array $data): array
  {
    return ResponseMediator::getContent($this->sara->getHttpClient()->post($this->base_url, ["Content-Type" => "application/json"], json_encode($data)));
  }
  public function continue(string $uuid)
  {
    $url = $this->base_url . "/" . $uuid . "/continue";
    ResponseMediator::getContent($this->sara->getHttpClient()->post($url));
  }
}
