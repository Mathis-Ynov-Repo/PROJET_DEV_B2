<?php

namespace App\EventSubscriber;

use App\Entity\Commandes;
use DateTime;
use DateTimeZone;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class DateAchatSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof Commandes) {
            $object->setDateAchat(new DateTime('now', new DateTimeZone('Europe/Paris')));
        }
    }
}
