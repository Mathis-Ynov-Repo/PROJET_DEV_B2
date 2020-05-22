<?php

namespace App\EventSubscriber;

use App\Entity\AbstractEntity;
use App\Entity\Commandes;
use App\Entity\Feedback;
use App\Entity\Restaurants;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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

        //Admins must be able to create as much restaurants as they want

        if ($token->getUser() instanceof UserInterface && in_array("ROLE_ADMIN", $token->getUser()->getRoles())) {
            return;
        }

        //Adds the user ID to restaurant (can only create 1), also adds userID to an order
        if ($object instanceof Commandes || $object instanceof Feedback || $object instanceof Restaurants && $token instanceof TokenInterface) {
            $object->setUser($token->getUser());
        }
    }
}
