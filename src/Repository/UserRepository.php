<?php

namespace App\Repository;

use App\Repository\AbstractRepository;
use User;

final class UserRepository extends AbstractRepository
{
  public function getUserByLogin($login): ?User
  {
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $this->connection->executeQuery($sql, [$login]);
    $data = $stmt->fetchAssociative();

    if ($data === false) {
      return null;
    }

    return new User(
      id: $data["id"],
      username: $data['username'],
      password: $data['password'],
    );
  }
}