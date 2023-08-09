<?php

namespace Company\Infrastructure\Repository;

use Company\Domain\Entity\Company;
use Company\Domain\Repository\CompanyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineCompanyRepository extends ServiceEntityRepository implements CompanyRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findOneBySlug(string $slug): ?Company
    {
        return $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Company::class, 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()->getOneOrNullResult();
    }
}