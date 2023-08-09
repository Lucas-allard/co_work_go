<?php

namespace Core\Presentation\Form;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SlugArrayField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('Core/slug_array_field.html.twig')
            ->setFormType(CollectionType::class)
            ->addCssClass('field-array')
            ->addJsFiles('bundles/easyadmin/form-type-collection.js');
    }
}