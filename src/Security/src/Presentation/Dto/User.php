<?php

namespace Security\Presentation\Dto;

use Security\Domain\Entity\User as UserEntity;
use Core\Infrastructure\Provider\UlidProvider;
use Core\Presentation\Dto\AbstractEntityDto;

final class User extends AbstractEntityDto
{
    #[Email]
    public string $email;

    public string $password;
    public array $companyIds;

    public function setId(string $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    function toNewEntity(mixed $repository): UserEntity
    {
        $user = (UserEntity::create(
            UlidProvider::staticGenerate(),
            $this->email,
            $this->password,
            $repository
        ));
        $this->setId($user->getId());

        return $user;
    }

    public function updateExistingEntity(mixed $entity, mixed $repository): void
    {
        parent::updateExistingEntity($entity, $repository);
        if ($this->email !== $entity->getCredentials()->getEmail()) {
            $entity->getCredentials()->setEmailAndCheckUniqueness($this->email, $repository);
        }
    }

    public function getCompanyIds(): array
    {
        return $this->companyIds;
    }


}