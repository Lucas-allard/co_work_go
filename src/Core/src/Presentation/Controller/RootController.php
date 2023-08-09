<?php

namespace Core\Presentation\Controller;

use Company\Presentation\Controller\CompanySwitcherFormController;
use Security\Domain\ValueObject\ROLES;
use Security\Infrastructure\ValueObject\SymfonySecurityUser;
use Security\Presentation\Controller\AdminDashboardController;
use Security\Presentation\Controller\MerchantDashboardController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/', name: self::class)]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class RootController implements ControllerInterface
{
    public function __construct(
        private Security              $security,
        private UrlGeneratorInterface $urlGenerator,
        private TokenStorageInterface $tokenStorage,
    )
    {
    }

    public function __invoke(Request $request): RedirectResponse
    {
        if ($this->security->isGranted(ROLES::Administrator()->getValue())) {
            return new RedirectResponse(
                $this->urlGenerator->generate(AdminDashboardController::class)
            );
        }

        /** @var SymfonySecurityUser $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if (count($user->getCompanyIds()) === 0) {
            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add(
                'danger',
                'You haven\'t any company linked to your account.'
            );
            return new RedirectResponse(
                $this->urlGenerator->generate('logout')
            );
        }

        return new RedirectResponse(
            $this->urlGenerator->generate(CompanySwitcherFormController::class)
        );
    }

}