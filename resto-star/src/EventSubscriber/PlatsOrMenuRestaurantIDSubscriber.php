<?php

namespace App\EventSubscriber;


use App\Entity\Menu;
use App\Entity\Plats;
use App\Entity\Restaurants;
use App\Repository\RestaurantsRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class PlatsOrMenuRestaurantIDSubscriber implements EventSubscriber
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

        if ($object instanceof Plats || $object instanceof Menu && $token instanceof TokenInterface) {
            $repository = $args->getObjectManager()->getRepository(Restaurants::class);
            $object->setRestaurant($repository->findOneBy(['user' => $token->getUser()]));
        }
    }
}
