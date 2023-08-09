<?php

namespace Core\Infrastructure\EventSubscriber;

use Core\Domain\Contract\Dateable\DateableInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DateableSubscriber implements EventSubscriberInterface

{

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => 'prePersist',
            Events::preUpdate => 'preUpdate'
        ];
    }

    /**
     * @param PrePersistEventArgs $args
     * @return void
     */
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

       if (!$entity instanceof DateableInterface) {
            return;
        }

        $entity->setCreatedAt();
    }

    /**
     * @param PrePersistEventArgs $args
     * @return void
     */
    public function preUpdate(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof DateableInterface) {
            return;
        }

        $entity->setUpdatedAt();
    }
}