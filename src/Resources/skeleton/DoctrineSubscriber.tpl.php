<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;

class <?= $class_name ?> implements EventSubscriberInterface
{
    public function prePersist(LifecycleEventArgs $args): void
    {
        dump($args);
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }
}
