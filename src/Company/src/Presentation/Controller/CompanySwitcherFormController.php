<?php

namespace Company\Presentation\Controller;

use Company\Domain\Provider\CompanyProviderInterface;
use Company\Presentation\Dto\CompanySwitcherDto;
use Core\Presentation\Controller\ControllerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

final class CompanySwitcherFormController implements ControllerInterface
{

    public function __construct(
        private FormFactoryInterface     $formFactory,
        private Environment              $twig,
        private TokenStorageInterface    $tokenStorage,
        private UrlGeneratorInterface    $urlGenerator,
        private CompanyProviderInterface $companyProvider
    )
    {
    }

    public function __invoke(Request $request): string
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $companyIds = $user->getCompanyIds();

        if (count($companyIds) === 1) {
            return $this->redirectToCompanySwitcher($companyIds[0]);
        } elseif ($this->companyProvider->hasSelectedCompany()) {
            return $this->redirectToCompanyDashboard();
        }

        $form = $this->formFactory->create(
            CompanySwitcherFormType::class,
            new CompanySwitcherDto
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CompanySwitcherDto $companySwitcherDto */
            $companySwitcherDto = $form->getData();
            return $this->redirectToCompanySwitcher($companySwitcherDto->company->getId());
        }

        return new Response(
            $this->twig->render('Core/company_switcher.html.twig', [
                'form' => $form->createView()
            ])
        );


    }

    private function redirectToCompanySwitcher(string $id): Response
    {
        return new RedirectResponse(
            $this->urlGenerator->generate(CompanySwitcherFormController::class, [
                "id" => $id
            ])
        );
    }

    private function redirectToCompanyDashboard()
    {
    }
}