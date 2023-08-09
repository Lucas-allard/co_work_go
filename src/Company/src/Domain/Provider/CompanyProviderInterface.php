<?php

namespace Company\Domain\Provider;

interface CompanyProviderInterface
{
    public function setCompany(string $companyId): void;

    public function getCompany(): string;

    public function hasSelectedCompany(): bool;
}