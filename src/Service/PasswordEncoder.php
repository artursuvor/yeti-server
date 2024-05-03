<?php

use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class PasswordEncoder implements PasswordHasherInterface
{
  public function hash(string $plainPassword): string
  {
      // ... hash the plain password in a secure way

      return $hashedPassword;
  }

  public function verify(string $hashedPassword, string $plainPassword): bool
  {
      if ('' === $plainPassword) {
          return false;
      }

      // ... validate if the password equals the user's password in a secure way

      return $passwordIsValid;
  }

  public function needsRehash(string $hashedPassword): bool
  {
      // Check if a password hash would benefit from rehashing
      return $needsRehash;
  }
}