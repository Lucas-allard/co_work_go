<?php

namespace Security\Application\Command\CreateUser;

use Core\Domain\Provider\IdProviderInterface;
use Security\Domain\Entity\User;
use Security\Domain\Repository\UserRepositoryInterface;
use Security\Domain\ValueObject\ROLES;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateUserHandler
{
public function __construct(
    private IdProviderInterface $idProvider,
    private UserRepositoryInterface $userRepository
){}

    public function __invoke(CreateUserCommand $command): void
    {
        $user = User::create(
            $this->idProvider->generate(),
            $command->email,
            $command->password,
            $this->userRepository
        );

        $user->setRole(ROLES::Administrator());

        $this->userRepository->store($user);
    }
}