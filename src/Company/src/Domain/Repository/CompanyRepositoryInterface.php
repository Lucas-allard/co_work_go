<?php

namespace Company\Domain\Repository;

use Company\Domain\Entity\Company;

interface CompanyRepositoryInterface
{

    public function findOneBySlug(string $slug): ?Company;
}