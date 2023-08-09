<?php

namespace Security\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use Core\Domain\Contract\Enableable\EnableableInterface;
use Core\Domain\Contract\Enableable\EnableableTrait;
use Core\Domain\Contract\Ulidable\UlidableInterface;
use Core\Domain\Contract\Ulidable\UlidableTrait;
use Security\Domain\Repository\UserRepositoryInterface;
use Security\Domain\ValueObject\Credentials;
use Security\Domain\ValueObject\ROLES;

class User implements UlidableInterface, EnableableInterface
{
    use UlidableTrait;
    use EnableableTrait;

    private Credentials $credentials;
    private string $role;

    private array $companyIds = [];
    private function __construct(){}

    static function create(
        string $id,
        string $email,
        string $password,
        UserRepositoryInterface $userRepository
    ): self {
        return (new self())
            ->setId($id)
            ->setCredentials(Credentials::create($email, $password, $userRepository))
            ;
    }

    function signIn(string $plainPassword): void
    {
        if(!$this->credentials->getHashedPassword()->match($plainPassword)){
            throw new \InvalidArgumentException("Invalid password.");
        }
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    private function setCredentials(Credentials $credentials): User
    {
        $this->credentials = $credentials;
        return $this;
    }

    function getRoles(): array
    {
        return [$this->getRole()];
    }

    public function getRole(): string
    {
        return ROLES::from($this->role);
    }

    public function setRole(ROLES $role): User
    {
        $this->role = $role->getValue();
        return $this;
    }

    public function getEmail(): string
    {
        return $this->getCredentials()->getEmail();
    }

    public function getCompanyIds(): array
    {
        return $this->companyIds;
    }

    public function setCompanyIds(array $companyIds): User
    {
        $this->companyIds = [];
        foreach ($companyIds as $companyId) {
            $this->addCompanyId($companyId);
        }

        return $this;
    }

    public function addCompanyId(string $companyId): User
    {
        if (!in_array($companyId, $this->companyIds)) {
            $this->companyIds[] = $companyId;
        }

        return $this;
    }

    public function removeCompanyId(string $companyId): User
    {
        if (in_array($companyId, $this->companyIds)) {
            $this->companyIds = array_diff($this->companyIds, [$companyId]);
        }

        return $this;
    }
}