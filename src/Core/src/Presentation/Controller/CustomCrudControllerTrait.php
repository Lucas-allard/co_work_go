<?php declare(strict_types=1);

namespace Core\Presentation\Controller;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\HttpFoundation\Response;

trait CustomCrudControllerTrait
{
    public function new(AdminContext $context): KeyValueStore|Response
    {
        $event = new BeforeCrudActionEvent($context);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
            throw new ForbiddenActionException($context);
        }

        if (!$context->getEntity()->isAccessible()) {
            throw new InsufficientEntityPermissionException($context);
        }

        //$context->getEntity()->setInstance($this->createEntity($context->getEntity()->getFqcn()));
        //$this->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_NEW)));
        $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());

        $entityDto = $context->getEntity();
        $formOptions = $context->getCrud()->getNewFormOptions();
        $cssClass = sprintf('ea-%s-form', $context->getCrud()->getCurrentAction());
        $formOptions->set('attr.class', trim(($formOptions->get('attr.class') ?? '').' '.$cssClass));
        $formOptions->set('attr.id', sprintf('new-%s-form', $entityDto->getName()));
        $formOptions->setIfNotSet('translation_domain', $context->getI18n()->getTranslationDomain());

        $newForm = $this->createNewForm($entityDto, $formOptions, $context);
        $newForm->handleRequest($context->getRequest());

        $entityInstance = $newForm->getData();
        //$context->getEntity()->setInstance($entityInstance);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            //$this->processUploadedFiles($newForm);

            $event = new BeforeEntityPersistedEvent($entityInstance);
            $this->container->get('event_dispatcher')->dispatch($event);
            $entityInstance = $event->getEntityInstance();

            //$this->persistEntity($this->container->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);
            $this->createAndStoreFromDto($entityInstance);

            $this->container->get('event_dispatcher')->dispatch(new AfterEntityPersistedEvent($entityInstance));
            $context->getEntity()->setInstance($entityInstance);

            $url = $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($entityInstance->getId())
                ->generateUrl();
            return $this->redirect($url);
        }

        $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
            'pageName' => Crud::PAGE_NEW,
            'templateName' => 'crud/new',
            'entity' => $context->getEntity(),
            'new_form' => $newForm,
        ]));

        $event = new AfterCrudActionEvent($context, $responseParameters);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        return $responseParameters;
    }

    public function edit(AdminContext $context): KeyValueStore|Response
    {
        $event = new BeforeCrudActionEvent($context);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::EDIT, 'entity' => $context->getEntity()])) {
            throw new ForbiddenActionException($context);
        }

        if (!$context->getEntity()->isAccessible()) {
            throw new InsufficientEntityPermissionException($context);
        }

        //$this->container->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_EDIT)));
        $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());
        //$entityInstance = $context->getEntity()->getInstance();

        /*if ($context->getRequest()->isXmlHttpRequest()) {
            $fieldName = $context->getRequest()->query->get('fieldName');
            $newValue = 'true' === mb_strtolower($context->getRequest()->query->get('newValue'));

            $event = $this->ajaxEdit($context->getEntity(), $fieldName, $newValue);
            if ($event->isPropagationStopped()) {
                return $event->getResponse();
            }

            // cast to integer instead of string to avoid sending empty responses for 'false'
            return new Response((int) $newValue);
        }*/

        $entityDto = $context->getEntity();
        $formOptions = $context->getCrud()->getEditFormOptions();
        $cssClass = sprintf('ea-%s-form', $context->getCrud()->getCurrentAction());
        $formOptions->set('attr.class', trim(($formOptions->get('attr.class') ?? '').' '.$cssClass));
        $formOptions->set('attr.id', sprintf('edit-%s-form', $entityDto->getName()));
        $formOptions->setIfNotSet('translation_domain', $context->getI18n()->getTranslationDomain());

        $editForm = $this->createEditForm($entityDto, $formOptions, $context);
        $editForm->handleRequest($context->getRequest());
        $entityInstance = $editForm->getData();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->processUploadedFiles($editForm);

            $event = new BeforeEntityUpdatedEvent($entityInstance);
            $this->container->get('event_dispatcher')->dispatch($event);
            $entityInstance = $event->getEntityInstance();

            $this->updateAndStoreFromDto($context->getEntity()->getInstance(), $entityInstance);

            $this->container->get('event_dispatcher')->dispatch(new AfterEntityUpdatedEvent($entityInstance));


            $url = empty($context->getReferrer())
                ? $this->container->get(AdminUrlGenerator::class)->setAction(Action::DETAIL)->generateUrl()
                : $context->getReferrer();

            return $this->redirect($url);
        }

        $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
            'pageName' => Crud::PAGE_EDIT,
            'templateName' => 'crud/edit',
            'edit_form' => $editForm,
            'entity' => $context->getEntity(),
        ]));

        $event = new AfterCrudActionEvent($context, $responseParameters);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        return $responseParameters;
    }
}