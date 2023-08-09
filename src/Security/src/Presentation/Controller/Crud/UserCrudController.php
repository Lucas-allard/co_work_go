<?php

namespace Security\Presentation\Controller\Crud;

use Core\Presentation\Controller\CustomCrudControllerInterface;
use Core\Presentation\Controller\CustomCrudControllerTrait;
use Core\Presentation\Dto\DtoInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Security\Infrastructure\Repository\DoctrineUserRepository;
use Security\Presentation\Dto\User as UserDto;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Security\Domain\Entity\User;
use Security\Domain\ValueObject\ROLES;
use Security\Presentation\Form\UserFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

abstract class UserCrudController extends AbstractCrudController implements CustomCrudControllerInterface
{
    use CustomCrudControllerTrait;

    public function __construct(
        protected DoctrineUserRepository $userRepository,
        protected FormFactoryInterface $formFactory
    ) {
    }

    abstract public static function getUserRole(): ROLES;

    public static function getName(): string
    {
        return static::getUserRole()->getKey();
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural(self::getName().'s')
            ->setEntityLabelInSingular(self::getName())
            ->setPaginatorPageSize(200)
//            ->overrideTemplate('crud/new', 'Core/CRUD/new.html.twig')
//            ->overrideTemplate('crud/edit', 'Core/CRUD/edit.html.twig')
            //->setDefaultSort(['credentials.email' => 'ASC'])
            //->setSearchFields(['credentials.email', 'companyIds'])
            ;
    }
//
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->setMaxLength(-1)->onlyOnDetail();
        yield BooleanField::new('enabled');
        yield EmailField::new('credentials.email', 'Email');
    }

    //INDEX
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return $this->userRepository->getIndexCrudQueryBuilderForRole($this->getUserRole());
    }

    public function createNewForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
    {
        return $this->formFactory->create(UserFormType::class, new UserDto(), $formOptions->all());
    }

    /**
     * @param UserDto $dto
     */
    public function createAndStoreFromDto(DtoInterface $dto): void
    {
        $user = $dto->toNewEntity($this->userRepository);
        $user->setRole($this->getUserRole());
        $this->userRepository->store($user);
    }

    public function createEditForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
    {
        $cssClass = sprintf('ea-%s-form', $context->getCrud()->getCurrentAction());
        $formOptions->set('attr.class', trim(($formOptions->get('attr.class') ?? '').' '.$cssClass));
        $formOptions->set('attr.id', sprintf('edit-%s-form', $entityDto->getName()));
        //$formOptions->set('entityDto', $entityDto);
        $formOptions->setIfNotSet('translation_domain', $context->getI18n()->getTranslationDomain());

        $instance = $entityDto->getInstance();
        $dto = UserDto::fromEntity($instance);

        return $this->formFactory->create(UserFormType::class, $dto, $formOptions->all());
    }

    /**
     * @param User    $entity
     * @param UserDto $dto
     */
    public function updateAndStoreFromDto(mixed $entity, DtoInterface $dto): void
    {
        $dto->updateExistingEntity($entity, $this->userRepository);
        $this->userRepository->update($entity);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->userRepository->remove($entityInstance);
    }
}