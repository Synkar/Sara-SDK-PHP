<?php

declare(strict_types=1);

namespace Sara\HiveMind;

use Sara\Client\ResponseMediator;
use Sara;

final class Localities
{
  private Sara $sara;
  private string $base_url = "/v1/hivemind/localities";

  public function __construct(Sara $sara)
  {
    $this->sara = $sara;
  }

  public function list(int $page = 1, int $limit = 10, string $slug = ""): array
  {
    $url = $this->base_url . "/?page=" . $page . "&limit=" . $limit . ($slug != "" ? "&name=" . $slug : "");
    return ResponseMediator::getContent($this->sara->getHttpClient()->get($url));
  }
  public function retrieve(string $uuid): array
  {
    $url = $this->base_url . "/" . $uuid . "/";
    return ResponseMediator::getContent($this->sara->getHttpClient()->get($url));
  }
  public function create(array $data): array
  {
    return ResponseMediator::getContent($this->sara->getHttpClient()->post($this->base_url), [], http_build_query($data));
  }
  public function delete(string $uuid): bool
  {
    $url = $this->base_url . "/" . $uuid . "/";
    ResponseMediator::getContent($this->sara->getHttpClient()->delete($url));
    return true;
  }
  public function update(string $uuid, array $data): array
  {
    $url = $this->base_url . "/" . $uuid . "/";
    return ResponseMediator::getContent($this->sara->getHttpClient()->patch($url, [], http_build_query($data)));
  }
}
