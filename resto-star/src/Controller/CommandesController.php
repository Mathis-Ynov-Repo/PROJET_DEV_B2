<?php

namespace App\Controller;

use App\Entity\CommandePlats;
use App\Entity\Commandes;
use App\Form\CommandePlatsType;
use App\Form\CommandeType;
use App\Repository\CommandePlatsRepository;
use App\Repository\CommandesRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandesController extends AbstractBaseController
{
    private $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/commande-details", name="commande_details_ajout", methods={"POST"})
     */

    public function createDetails(
        \Swift_Mailer $mailer,
        Request $request
    ) {
        $commandes = [];
        $errors = null;
        $data = json_decode($request->getContent(), true);
        foreach ($data as $line) {
            $commandePlat = new CommandePlats();
            $form = $this->createForm(CommandePlatsType::class, $commandePlat,  array('csrf_protection' => false));

            $form->submit($line);

            if ($form->isSubmitted() && $form->isValid()) {
                array_push($commandes, $commandePlat);
                $this->em->persist($commandePlat);
            } else {
                $errors = $this->getFormErrors($form);
                return $this->json(
                    $errors,
                    Response::HTTP_BAD_REQUEST
                );
            }
        }
        if (is_null($errors)) {
            $this->em->flush();
            $commande = $commandes[0]->getCommande();

            $dateLivraison = new DateTime($commande->getDateAchat()->format('Y-m-d H:i:s'));

            $dateLivraison->add(new DateInterval('PT1H'));
            $message = (new \Swift_Message('A new order has been added'))
                ->setFrom('eyzex972@gmail.com')
                ->setTo('contact@les-tilleuls.coop')
                ->setBody(
                    $this->renderView(
                        'emails/mail.html.twig',
                        [
                            'commande' => $commande,
                            'dateLivraison' => $dateLivraison
                        ]
                    ),
                    'text/html'
                );

            $mailer->send($message);
            return $this->json(
                $commandes,
                Response::HTTP_CREATED,
                [],
                ["groups" => "commande-plats:details"]
            );
        }
    }
}
