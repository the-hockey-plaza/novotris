<?php

require_once __DIR__ . '/NovotrisHttpException.php';
require_once __DIR__ . '/DbRepository.php';

class DbService
{
  private DbRepository $repository;

  public function __construct(DbRepository $repository)
  {
    $this->repository = $repository;
  }

  public function getAuthenticatedUserIdOrNull(): ?int
  {
    if (!isset($_SESSION['nov_user_id'])) {
      return null;
    }

    return (int)$_SESSION['nov_user_id'];
  }

  public function requireAuthenticatedUserId(): int
  {
    $userId = $this->getAuthenticatedUserIdOrNull();
    if ($userId === null || $userId <= 0) {
      throw new NovotrisHttpException(401, 'unauthorized', 'Authentication required');
    }

    return $userId;
  }

  public function enforceAuthorization(string $functionname, array $request): void
  {
    switch ($functionname) {
      case 'saveLevelToDb':
        $this->requireOwnerByField($request, 'user_id');
        break;
      case 'saveUserSettingsToDb':
        $this->requireOwnerByField($request, 'id');
        break;
      case 'saveLanguageToDb':
        $this->requireOwnerByField($request, 'user_id');
        break;
      case 'saveUserNameToDb':
        $this->requireOwnerByField($request, 'id');
        break;
      case 'getUserInfo':
        $this->requireOwnerByField($request, 'user_id');
        break;
      case 'startGameOnDb':
        $this->requireOwnerByField($request, 'user_id');
        break;
      case 'stopGameOnDb':
        $this->requireGameOwner($this->requestValue($request, 'game_id'));
        break;
      case 'updateGameOnDb':
        $this->requireGameOwner($this->requestValue($request, 'game_id'));
        break;
      default:
        break;
    }
  }

  private function requestValue(array $request, string $key)
  {
    if (array_key_exists($key, $request)) {
      return $request[$key];
    }

    return null;
  }

  private function requireOwnerByField(array $request, string $fieldName): void
  {
    $authenticatedUserId = $this->requireAuthenticatedUserId();
    $targetUserId = (int)$this->requestValue($request, $fieldName);

    if ($targetUserId <= 0 || $targetUserId !== $authenticatedUserId) {
      throw new NovotrisHttpException(403, 'forbidden', 'Access denied for requested user');
    }
  }

  private function requireGameOwner($gameId): void
  {
    $authenticatedUserId = $this->requireAuthenticatedUserId();
    $ownerUserId = $this->repository->findGameOwnerId((int)$gameId);

    if ($ownerUserId === null) {
      throw new NovotrisHttpException(404, 'not_found', 'Game not found');
    }

    if ($ownerUserId !== $authenticatedUserId) {
      throw new NovotrisHttpException(403, 'forbidden', 'Access denied for requested game');
    }
  }
}
