<?php

namespace Security\Domain\ValueObject;

use Core\Domain\Contract\Emailable\EmailableInterface;
use Core\Domain\Contract\Emailable\EmailableTrait;
use DomainException;
use Security\Domain\Repository\UserRepositoryInterface;

final class Credentials implements EmailableInterface
{
    use EmailableTrait;
    private HashedPassword $hashedPassword;

    private function __construct(){}

    static function create(
        string $email,
        string $password,
        UserRepositoryInterface $userRepository
    ): self {
       self::assertEmailIsAvailable($email, $userRepository);
         return (new self())
              ->setEmail($email)
              ->setHashedPassword(HashedPassword::fromString($password));
    }

    public function setEmailAndCheckUniqueness(string $email, UserRepositoryInterface $userRepository): self
    {
        self::assertEmailIsAvailable($email, $userRepository);
        $this->setEmail($email);

        return $this;
    }

    private static function assertEmailIsAvailable(string $email, UserRepositoryInterface $userRepository): void
    {
        if($userRepository->findOneByEmail($email) !== null){
            throw new DomainException("This email is already taken.");
        }
    }

    private function setHashedPassword(HashedPassword $fromString): self
    {
        $this->hashedPassword = $fromString;

        return $this;
    }

    public function getHashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }
}