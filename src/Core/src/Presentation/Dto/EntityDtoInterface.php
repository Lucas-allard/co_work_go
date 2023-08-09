<?php

namespace Core\Presentation\Dto;

interface EntityDtoInterface extends DtoInterface
{
    function __construct();

    function getId(): string;

    static function fromEntity(mixed $entity): static;

    function toNewEntity(mixed $repository);

    function updateExistingEntity(mixed $entity, mixed $repository);
}