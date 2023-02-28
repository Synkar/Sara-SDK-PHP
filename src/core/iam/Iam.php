<?php

declare(strict_types=1);

namespace Sara;

use Sara\Client\ResponseMediator;
use Sara;

final class Iam
{
  private Sara $sara;
  private string $base_url = "/v1/iam";

  public function __construct(Sara $sara)
  {
    $this->sara = $sara;
  }

  public function hasPermission(): array
  {
    return ResponseMediator::getContent($this->sara->getHttpClient()->get($this->base_url . "/has-permission/"));
  }
}
