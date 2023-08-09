<?php

namespace Security\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Security\Domain\Entity\User;
use Security\Domain\Repository\UserRepositoryInterface;
use Security\Domain\ValueObject\ROLES;

final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $this->getEntityManager();
    }


    public function findOneById(string $id): ?User
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id, 'ulid')
            ->getQuery()->getOneOrNullResult();
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.credentials.email = :email')
            ->setParameter('email', $email)
            ->getQuery()->getOneOrNullResult();
    }

    public function store(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function update(User $user): void
    {
        $this->entityManager->flush();
    }

    public function findByRole(ROLES $role): iterable
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.role = :role')
            ->setParameter('role', $role->getValue())
            ->getQuery()->getResult();
    }

    public function getIndexCrudQueryBuilderForRole(ROLES $getUserRole): QueryBuilder
    {
        return $this->createQueryBuilder('u')
            ->where('u.role = :role')
            ->setParameter('role', $getUserRole->getValue());
    }
}