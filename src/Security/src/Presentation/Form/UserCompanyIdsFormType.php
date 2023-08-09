<?php

declare(strict_types=1);

namespace Security\Presentation\Form;

use Company\Domain\Repository\CompanyRepositoryInterface;
use Security\Presentation\Dto\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UserCompanyIdsFormType extends AbstractType
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $companies = [...$this->companyRepository->findAll()];
        usort($companies, fn($a, $b)=>strcmp($a->getSlug(), $b->getSlug()));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($companies) {
            $form = $event->getForm();
            /** @var User $data */
            $data = $event->getData();
            $form->add('companyIds', ChoiceType::class, [
                'mapped' => false,
                'choices' => $companies,
                'choice_value' => fn ($company) => $company?->getId(),
                'choice_label' => 'slug',
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => function ($choice, $key, $value) use ($data) {
                    return ['checked' => in_array($value, $data->companyIds)];
                },
            ]);
            $form->add('submit', SubmitType::class);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id' => self::class,
        ]);
    }
}
