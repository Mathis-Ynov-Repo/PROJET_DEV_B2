<?php

namespace App\EventListener;

use App\Entity\User;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $user->setLastConnection(new DateTime('now', new DateTimeZone('Europe/Paris')));
        $this->em->flush();

        $data['user'] = [
            'id' => $user->getId(),
            'email' => $user->getUsername(),
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'adress' => $user->getAdress(),
            'balance' => $user->getBalance(),
            'roles' => $user->getRoles(),
            'lastConnection' => $user->getLastConnection(),
        ];

        if ($user->getImage()) {
            $data['user']['image'] = $user->getImage()->filePath;
        }

        $event->setData($data);
    }
}
