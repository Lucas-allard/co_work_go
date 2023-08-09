<?php

namespace Company\Presentation\Dto;

use Company\Domain\Entity\Company;
use Core\Presentation\Dto\DtoInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class CompanySwitcherDto implements DtoInterface
{
    #[NotBlank]
    public Company $company;
}