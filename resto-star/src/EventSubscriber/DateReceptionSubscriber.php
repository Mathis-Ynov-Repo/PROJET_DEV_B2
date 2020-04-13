<?php

namespace App\EventSubscriber;

use App\Entity\Commandes;
use DateTime;
use DateTimeZone;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class DateReceptionSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof Commandes && $object->getStatut() != 'livrée') {
            $object->setDateReception(new DateTime('now', new DateTimeZone('Europe/Paris')));
        }
    }
}
