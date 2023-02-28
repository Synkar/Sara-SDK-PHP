<?php

declare(strict_types=1);

namespace Sara\Client;

use Psr\Http\Message\ResponseInterface;
use Error;

final class ResponseMediator
{
  public static function getContent(ResponseInterface $response): mixed
  {
    return json_decode($response->getBody()->getContents(), true);
  }
}
