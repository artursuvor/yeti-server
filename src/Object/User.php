<?php
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


final class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private int $id,
        private string $username,
        private string $password,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
        ];
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            $data["id"],
            $data["username"],
            $data["password"],
        );
    }

    public function getRoles(): array
    {
      return ['ROLE_ADMIN', 'ROLE_USER'];
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * Returns the identifier for this user (e.g. username or email address).
     */
    public function getUserIdentifier(): string
    {
      return $this->username;
    }

    public function verifyPassword($password):bool
    {
      return password_verify($password, $this->password);
    }
}
