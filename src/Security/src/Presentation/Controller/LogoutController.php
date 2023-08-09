<?php declare(strict_types=1);

namespace Security\Presentation\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/logout', name:'logout')]
final class LogoutController
{
    function __invoke(): Response
    {
        return new Response('Error', 500);
    }
}