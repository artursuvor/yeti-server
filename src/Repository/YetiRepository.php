<?php

namespace App\Repository;

use Yeti;
use YetiCrudException;

final class YetiRepository extends AbstractRepository
{
  public function createYeti(Yeti $yeti): void
  {
    $sql = "INSERT INTO yeti (name, height, weight, location, photo_url, gender) 
      VALUES (:name, :height, :weight, :location, :photo_url, :gender)";

    $parameters = [
      'name' => $yeti->getName(),
      'height' => $yeti->getHeight(),
      'weight' => $yeti->getWeight(),
      'location' => $yeti->getLocation(),
      'photo_url' => $yeti->getPhotoUrl(),
      'gender' => $yeti->getGender(),
    ];

    try {
      $this->connection->executeQuery($sql, $parameters);
    } catch (\PDOException $e) {
        throw new YetiCrudException("Failed to create new Yeti: " . $e->getMessage());
    }
  }

  public function getById(int $id): ?Yeti
  {
    $sql = "SELECT * FROM yeti WHERE id = ?";
    $stmt = $this->connection->executeQuery($sql, [$id]);
    $data = $stmt->fetchAssociative();

    if ($data === false) {
      return null;
    }

    return new Yeti(
      name: $data['name'],
      height: $data['height'],
      weight: $data['weight'],
      location: $data['location'],
      photoUrl: $data['photo_url'],
      gender: $data['gender'],
    );
  }
  
  public function deleteById(int $id): void
  {
    $sql = "DELETE FROM yeti WHERE id = ?";

    try {
      $this->connection->executeQuery($sql, [$id]); 
    } catch (\PDOException $e) {
        throw new YetiCrudException("Failed to delete Yeti: " . $e->getMessage());
    }
  }

  public function findAll(): array
  {
    $sql = "SELECT * FROM yeti";
    $stmt = $this->connection->executeQuery($sql);
    
    return $stmt->fetchAllAssociative();
  }
}