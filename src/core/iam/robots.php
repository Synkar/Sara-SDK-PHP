<?php

declare(strict_types=1);

namespace Sara\Iam;

use Sara\Client\ResponseMediator;
use Sara;

final class Robots
{
  private Sara $sara;
  private string $base_url = "/v1/iam/robots";

  public function __construct(Sara $sara)
  {
    $this->sara = $sara;
  }

  public function list(int $page = 1, int $pageSize = 10, string $name = ""): array
  {
    $url = $this->base_url . "?page=" . $page . "&page_size=" . $pageSize . ($name != "" ? "&name=" . $name : "");
    return ResponseMediator::getContent($this->sara->getHttpClient()->get($url));
  }
  public function create(array $data): array
  {
    return ResponseMediator::getContent($this->sara->getHttpClient()->post($this->base_url), [], $data);
  }
}
