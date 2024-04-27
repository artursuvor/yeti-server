<?php

namespace App\Repository;

use Review;
use ReviewException;

final class ReviewRepository extends AbstractRepository
{
  public function getAllReviewsByYetiId(int $yetiId): array
  {
    $sql = "SELECT * FROM review WHERE yeti_id = ?";
    $stmt = $this->connection->executeQuery($sql, [$yetiId]);
    $data = $stmt->fetchAllAssociative();

    if ($data === false) {
      return [];
    }
    
    $reviews = [];

    foreach ($data as $review) {
      $reviews[] = Review::createFromArray($review);
    }

    return $reviews;
  }
  public function addReview(Review $review): void
  {
    $sql = "INSERT INTO review (yeti_id, comment, rating) VALUES (:yetiId, :comment, :rating)";

    $parameters = [
        'yetiId' => $review->getYetiId(),
        'comment' => $review->getComment(),
        'rating' => $review->getRating(),
    ];

    try {
      $this->connection->executeQuery($sql, $parameters);
    } catch (\PDOException $e) {
        throw new ReviewException("Failed to create new Yeti: " . $e->getMessage());
    }
  }
}
