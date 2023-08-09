<?php

namespace Security\Presentation\Controller\Crud;

use Security\Domain\ValueObject\ROLES;

final class AdministratorCrudController extends UserCrudController
{
    public static function getUserRole(): ROLES
    {
        return ROLES::Administrator();
    }
}