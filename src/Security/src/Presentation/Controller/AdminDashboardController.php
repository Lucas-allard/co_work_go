<?php

namespace Security\Presentation\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Security\Domain\Entity\User;
use Security\Presentation\Controller\Crud\AdministratorCrudController;
use Security\Presentation\Controller\Crud\MerchantCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class AdminDashboardController extends AbstractDashboardController
{
    #[Route(path: '/admin', name: self::class)]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(AdministratorCrudController::class)->generateUrl());
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->addMenuItems(
                [
                    MenuItem::linkToDashboard('Home', 'fa fa-home'),
                    MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
                ]
            );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Co Work Go')
            ->setFaviconPath('build/images/favicon.png')
            ->setTranslationDomain('admin')
            ->renderContentMaximized()
            ->renderSidebarMinimized();
    }

    public function configureMenuItems(): iterable
    {
        // Security
        yield MenuItem::section('Security');
        yield MenuItem::linkToCrud(AdministratorCrudController::getName() . 's', 'fas fa-user-lock', User::class)
            ->setController(AdministratorCrudController::class);
        yield MenuItem::linkToCrud(MerchantCrudController::getName() . 's', 'fas fa-user-tie', User::class)
            ->setController(MerchantCrudController::class);
    }

//    public function configureAssets(): Assets
//    {
//        return parent::configureAssets()
//            ->addCssFile('css/style.css')
//            ->addCssFile('css/_image_type.css')
//            ->addJsFile('bundles/easyadmin/form-type-collection.js')
//            ->addJsFile('js/_image_type.js');
//    }

    public function configureActions(): Actions
    {
        return Actions::new()
            //->addBatchAction(Action::BATCH_DELETE)
            ->add(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            ->add(Crud::PAGE_DETAIL, Action::EDIT)
            ->add(Crud::PAGE_DETAIL, Action::INDEX)
            ->add(Crud::PAGE_DETAIL, Action::DELETE)

            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_EDIT, Action::new(Action::SAVE_AND_RETURN, 'Save', 'far fa-edit')
                ->addCssClass('btn btn-primary action-save')
                ->displayAsButton()
                ->setHtmlAttributes(['type' => 'submit', 'name' => 'ea[newForm][btn]', 'value' => Action::SAVE_AND_CONTINUE])
                ->linkToCrudAction(Action::DETAIL))

            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_RETURN);
    }
}