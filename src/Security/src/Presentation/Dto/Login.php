<?php

namespace Security\Presentation\Dto;

use Symfony\Component\Validator\Constraints\Email;

final class Login
{
    #[Email]
    private string $email;
    private string $password;

    function __construct(){}

    public function setEmail(string $email): Login
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): Login
    {
        $this->password = $password;
        return $this;
    }
}