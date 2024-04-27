<?php

final class Review
{
    public function __construct(
        private int $yetiId,
        private string $comment,
        private int $rating,
    ) {
    }

    public function getYetiId(): int
    {
        return $this->yetiId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function toArray(): array
    {
        return [
            "yetiId" => $this->yetiId,
            "comment" => $this->comment,
            "rating" => $this->rating,
        ];
    }

    public static function createFromArray(array $data): self
    {
      return new self(
          $data["yeti_id"],
          $data["comment"],
          $data["rating"],
      );
    }
}
