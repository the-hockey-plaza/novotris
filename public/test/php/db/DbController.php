<?php

require_once __DIR__ . '/NovotrisHttpException.php';
require_once __DIR__ . '/DbService.php';

class DbController
{
  private $service;
  private array $handlers;

  public function __construct($service, array $handlers)
  {
    $this->service = $service;
    $this->handlers = $handlers;
  }

  public function dispatch(string $functionname, array $request)
  {
    if (!isset($this->handlers[$functionname])) {
      throw new NovotrisHttpException(400, 'bad_request', 'Unknown functionname');
    }

    $this->service->enforceAuthorization($functionname, $request);

    $handler = $this->handlers[$functionname];
    return $handler($request);
  }
}
