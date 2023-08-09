<?php

namespace Security\Domain\Repository;

use Security\Domain\Entity\User;
use Security\Domain\ValueObject\ROLES;

interface UserRepositoryInterface
{
    public function findOneById(string $id): ?User;

    public function findOneByEmail(string $email): ?User;

    public function store(User $user): void;

    public function remove(User $user): void;

    public function update(User $user): void;

    /** @return iterable<User> */
    public function findByRole(ROLES $role): iterable;
}