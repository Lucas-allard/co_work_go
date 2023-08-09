<?php
//
//namespace Core\Infrastructure\EventSubscriber;
//
//use Core\Domain\Contract\Imageable\ImageableInterface;
//use Core\Domain\Provider\ImageProviderInterface;
//use Doctrine\ORM\Event\PostRemoveEventArgs;
//use Doctrine\ORM\Events;
//use Symfony\Component\EventDispatcher\EventSubscriberInterface;
//
//class ImageableSubscriber implements EventSubscriberInterface
//{
//    /**
//     * @param ImageProviderInterface $imageProvider
//     */
//    public function __construct(
//        private ImageProviderInterface $imageProvider
//    )
//    {
//    }
//
//    /**
//     * @return string[]
//     */
//    public static function getSubscribedEvents(): array
//    {
//        return [
//            Events::postRemove => 'postRemove',
//        ];
//    }
//
//    /**
//     * @param PostRemoveEventArgs $args
//     * @return void
//     */
//    public function postRemove(PostRemoveEventArgs $args): void
//    {
//        $entity = $args->getObject();
//        if (!$entity instanceof ImageableInterface || null === $entity->getImageUrl()) {
//            return;
//        }
//
//        $this->imageProvider->remove($entity->getImageUrl());
//    }
//}