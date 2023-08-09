<?php

namespace Security\Presentation\Controller;

use Core\Presentation\Controller\RootController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

#[Route(path: "/login", name: 'login')]
final class LoginController extends AbstractController
{
    function __construct(
        private AuthenticationUtils $authenticationUtils,
        private Environment         $twig,
    )
    {
    }

    function __invoke(): Response
    {
        if ($this->isGranted("IS_AUTHENTICATED_FULLY")) {
            return $this->redirectToRoute(RootController::class);
        }

        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();
        return $this->render('Security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            'page_title' => 'Co Work Go',
            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl(RootController::class),
            'username_parameter' => 'email',
            'password_parameter' => 'password',
        ]);
    }
}