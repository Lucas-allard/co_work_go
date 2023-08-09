<?php

namespace Security\Presentation\Form;

use Security\Presentation\Dto\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class);
        $builder->add('password', PasswordType::class, [
            'attr' => [
                'autocomplete' => 'new-password',
            ],
        ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var User $data */
            $data = $event->getData();
            if ($data->id ?? false) {
                $event->getForm()->add('password', PasswordType::class, [
                    'attr' => [
                        'autocomplete' => 'new-password'
                    ],
                    'help' => 'Leave empty to keep actual one.',
                    'required' => false
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => self::class,
        ]);
    }
}