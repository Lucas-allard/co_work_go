<?php

namespace Security\Infrastructure\ValueObject;

use Security\Domain\Entity\User;
use Security\Domain\ValueObject\ROLES;
use Symfony\Component\Security\Core\User\UserInterface;

final class SymfonySecurityUser implements UserInterface
{

    public function __construct(
        private User $user
    )
    {
    }

    public function getRoles(): array
    {
        return [$this->user->getRole()];
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return $this->user->getCredentials()->getEmail();
    }

    public function getPassword(): ?string
    {
        return (string)$this->user->getCredentials()->getHashedPassword();
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array<string>
     */
    public function getCompanyIds(): array
    {
        return $this->user->getCompanyIds();
    }
}