<?php

namespace Core\Presentation\Controller;

use Core\Presentation\Dto\EntityDtoInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

interface CustomCrudControllerInterface
{
    public function new(AdminContext $context): KeyValueStore|Response;

    public function edit(AdminContext $context): KeyValueStore|Response;

    public function createNewForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface;

    public function createAndStoreFromDto(EntityDtoInterface $dto): void;

    public function createEditForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface;

    public function updateAndStoreFromDto(mixed $entity, EntityDtoInterface $dto): void;

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void;
}