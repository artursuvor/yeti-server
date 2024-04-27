<?php

final class Yeti 
{
  public function __construct(
    private string $name,
    private int $height,
    private int $weight,
    private string $location,
    private ?string $photoUrl,
    private string $gender,
  ) {
  }

  public function getName(): string 
  {
    return $this->name;
  }

  public function getHeight(): int
  {
    return $this->height;
  }

  public function getWeight(): int
  {
    return $this->weight;
  }

  public function getLocation(): string
  {
    return $this->location;
  }

  public function getPhotoUrl(): ?string
  {
    return $this->photoUrl;
  }

  public function getGender(): string
  {
    return $this->gender;
  }

  public function toArray(): array
  {
    return [
      "name"=> $this->name,
      "height"=> $this->height,
      "weight"=> $this->weight,
      "location"=> $this->location,
      "photoUrl"=> $this->photoUrl,
      "gender"=> $this->gender,
    ];
  }
}