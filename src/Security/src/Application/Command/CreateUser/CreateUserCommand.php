<?php

namespace Security\Application\Command\CreateUser;

use Symfony\Component\Validator\Constraints\Email;

final class CreateUserCommand
{

    #[Email]
    public string $email;

    public string $password;

    public function __construct(){}

    public function setEmail(string $email): CreateUserCommand
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): CreateUserCommand
    {
        $this->password = $password;
        return $this;
    }

}