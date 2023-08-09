<?php

namespace Core\Presentation\Dto;

use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class AbstractEntityDto implements EntityDtoInterface
{
    public string $id;

    public function __construct()
    {
    }

    function getId(): string
    {
        return $this->id;
    }

    static function fromEntity(mixed $entity): static
    {
        $dto = new static();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach(get_class_vars(static::class) as $var=>$value){
            if($propertyAccessor->isReadable($entity, $var)){
                $propertyAccessor->setValue($dto, $var, $propertyAccessor->getValue($entity, $var));
            }
        }
        return $dto;
    }

    function updateExistingEntity(mixed $entity, mixed $repository): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach(get_class_vars(static::class) as $var=>$value){
            if($propertyAccessor->isWritable($entity, $var)){
                $propertyAccessor->setValue($entity, $var, $propertyAccessor->getValue($this, $var));
            }
        }
    }
}