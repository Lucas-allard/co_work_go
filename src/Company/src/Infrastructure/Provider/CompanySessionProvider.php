<?php

namespace Company\Infrastructure\Provider;

use Company\Domain\Provider\CompanyProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class CompanySessionProvider implements CompanyProviderInterface
{
    public function __construct(
        private RequestStack $requestStack
    ){}

    public function setCompany(string $companyId): void
    {
        $session = $this->requestStack->getSession();
        $session->set('company', $companyId);
    }

    public function getCompany(): string
    {
        $session = $this->requestStack->getSession();
        return $session->get('company');
    }

    public function hasSelectedCompany(): bool
    {
        $session = $this->requestStack->getSession();
        return $session->has('company');
    }
}