<?php

namespace App\EventSubscriber;

use App\Entity\AbstractEntity;
use App\Entity\Commandes;
use App\Entity\Restaurants;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class EntityUserIDSubscriber implements EventSubscriber
{
    private $tokenStorage;

    public function __construct(
        TokenStorageInterface $storage
    ) {
        $this->tokenStorage = $storage;
    }
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        $token = $this->tokenStorage->getToken();

        if ($object instanceof Commandes || $object instanceof Restaurants && $token instanceof TokenInterface) {
            $object->setUser($token->getUser());
        }
    }
}
