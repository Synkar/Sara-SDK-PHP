<?php

declare(strict_types=1);

namespace Sara;

use Sara\Client\ResponseMediator;
use Sara;
use Sara\HiveMind\Requests;

final class Hivemind
{
  private Sara $sara;
  private string $base_url = "/v1/hivemind";

  public function __construct(Sara $sara)
  {
    $this->sara = $sara;
  }

  public function requests(): Requests
  {
    return new Requests($this->sara);
  }
}
