<?php

namespace Security\Infrastructure\Provider;

use Security\Domain\Repository\UserRepositoryInterface;
use Security\Infrastructure\ValueObject\SymfonySecurityUser;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class SymfonySecurityUserProvider implements UserProviderInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return SymfonySecurityUser::class === $class || is_subclass_of($class, SymfonySecurityUser::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findOneByEmail($identifier);
        if (!$user || !$user->isEnabled()) {
            throw new UserNotFoundException();
        }
        return new SymfonySecurityUser($user);
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }
}