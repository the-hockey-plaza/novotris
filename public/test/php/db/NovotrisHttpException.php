<?php

class NovotrisHttpException extends RuntimeException
{
  private int $statusCode;
  private string $errorCode;

  public function __construct(int $statusCode, string $errorCode, string $message)
  {
    parent::__construct($message);
    $this->statusCode = $statusCode;
    $this->errorCode = $errorCode;
  }

  public function getStatusCode(): int
  {
    return $this->statusCode;
  }

  public function getErrorCode(): string
  {
    return $this->errorCode;
  }
}
