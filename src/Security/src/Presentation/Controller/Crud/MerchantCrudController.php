<?php

namespace Security\Presentation\Controller\Crud;

use Core\Presentation\Form\SlugArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Security\Domain\Entity\User;
use Security\Domain\ValueObject\ROLES;
use Security\Infrastructure\Repository\DoctrineUserRepository;
use Security\Presentation\Form\UserCompanyIdsFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class MerchantCrudController extends UserCrudController
{
    public function __construct(
        DoctrineUserRepository $userRepository,
        FormFactoryInterface   $formFactory
    )
    {
        parent::__construct($userRepository, $formFactory);
    }

    public static function getUserRole(): ROLES
    {
        return ROLES::Merchant();
    }

    public function configureFields(string $pageName): iterable
    {
        yield from parent::configureFields($pageName);
        yield SlugArrayField::new('companyIds', 'Companies');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->add(
            Crud::PAGE_INDEX,
            Action::new('companies', 'Companies')
                ->linkToCrudAction('companies')
                ->addCssClass('text-dark')
        );

        return $actions;
    }

    public function companies(AdminContext $context, Request $request): Response|KeyValueStore
    {
        $context->getCrud()->setPageName('new');
        $actions = Actions::new()->add(
            Crud::PAGE_NEW,
            Action::INDEX
        );

        $actionConfigDto = $actions->getAsDto('new');
        $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $actionConfigDto);

        /** @var User $user */
        $user = $context->getEntity()->getInstance();
        $dto = \Security\Presentation\Dto\User::fromEntity($user);
        $form = $this->formFactory->create(
            UserCompanyIdsFormType::class,
            $dto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $companyIds = $form->get('companyIds')->getViewData();
            $user->setCompanyIds($companyIds);
            $this->userRepository->update($user);

            $url = $this->get(AdminUrlGenerator::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($user->getId())
                ->generateUrl();

            return $this->redirect($url);
        }

        return $this->configureResponseParameters(KeyValueStore::new([
            'pageName' => Crud::PAGE_NEW,
            'templateName' => 'crud/new',
            'entity' => $context->getEntity(),
            'new_form' => $form,
        ]));
    }
}