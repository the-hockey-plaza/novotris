<?php

class DbRepository
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function findGameOwnerId(int $gameId): ?int
  {
    $statement = $this->pdo->prepare("SELECT user_id FROM game WHERE id = ?");
    $statement->execute([$gameId]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
      return null;
    }

    return (int)$row['user_id'];
  }
}
