<?php

declare(strict_types=1);

namespace Sara;

use Sara;
use Sara\HiveMind\Requests;
use Sara\HiveMind\Localities;
use Sara\HiveMind\Operations;

final class Hivemind
{
  private Sara $sara;
  private string $base_url = "/v2/hivemind";

  public function __construct(Sara $sara)
  {
    $this->sara = $sara;
  }

  public function requests(): Requests
  {
    return new Requests($this->sara);
  }

  public function localities(): Localities
  {
    return new Localities($this->sara);
  }

  public function operations(): Operations
  {
    return new Operations($this->sara);
  }
}
