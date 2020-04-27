<?php
// api/src/EventSubscriber/BookMailSubscriber.php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Commandes;
use DateInterval;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Constraints\Date;

final class CommandeMailSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['sendMail', EventPriorities::POST_WRITE],
        ];
    }

    public function sendMail(ViewEvent $event): void
    {
        $commande = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$commande instanceof Commandes || Request::METHOD_POST !== $method) {
            return;
        }
        // $plat = $commande->getCommandePlats()->get(0);
        $dateLivraison = new DateTime($commande->getDateAchat()->format('Y-m-d H:i:s'));

        $dateLivraison->add(new DateInterval('PT1H'));
        $message = (new \Swift_Message('A new command has been added'))
            ->setFrom('eyzex972@gmail.com')
            ->setTo('contact@les-tilleuls.coop')
            ->setBody("
        You have a new command #{$commande->getId()} ( {$commande->getPrix()}$ ).
        The list of ordered dishes is available on the site.
        Customer's Adresss : {$commande->getUser()->getAdress()}, 
        Estimated Delivery Time : {$dateLivraison->format('d/m/Y H:i:s')} ");

        $this->mailer->send($message);
    }
}
