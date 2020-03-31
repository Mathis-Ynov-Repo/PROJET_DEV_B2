<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Form\CommandeType;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandesController extends AbstractBaseController
{
    private $em;

    function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    /**
     * @Route("/commandes", name="liste_commandes", methods={"GET"})
     */
    public function list(CommandesRepository $commandesRepository) {
        $plats = $commandesRepository->findAll();

        return $this->json(
            $plats,
            Response::HTTP_OK,
            [],
            //['groups' => 'commandes:details']
        );
    }
    /**
     * @Route("/commandes/{id}", name="commandes_details", methods={"GET"})
     */
    public function detail(Commandes $commande)
    {
        return $this->json(
        ['commande' => $commande], // données à sérialiser
        Response::HTTP_OK, // Code de réponse HTTP
        [], // En-têtes
        //['groups' => 'commandes:details'] // Contexte
        );
    }

    /**
     * @Route("/commandes", name="commandes_ajout", methods={"POST"})
     */
    public function create(
        Request $request
    ) {
        $data = json_decode($request->getContent(), true);
        $commande = new Commandes();
        $form = $this->createForm(CommandeType::class, $commande);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($commande);
        $this->em->flush();

        return $this->json(
            $commande,
            Response::HTTP_CREATED,
            [],
            //["groups" => "commandes:details"]
        );
        }
        $errors = $this->getFormErrors($form); 
        return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @Route("/commandes/{id}", name="commandes_patch", methods={"PATCH"})
     */
    public function patch(Commandes $commande, Request $request)
    {
        return $this->update($request, $commande, false);
    }

    /**
     * @Route("/commandes/{id}", name="commandes_put", methods={"PUT"})
     */
    public function put(Commandes $commande, Request $request)
    {
        return $this->update($request, $commande);
    }

    /**
     * @Route("/commandes/{id}", name="commandes_suppression", methods={"DELETE"})
     */
    public function delete(Commandes $commande)
    {
        $this->em->remove($commande);
        $this->em->flush();

        return $this->json('ok');
    }

    private function update(
        Request $request,
        Commandes $commande,
        bool $clearMissing = true
      ) {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(CommandeType::class, $commande);
    
        $form->submit($data, $clearMissing);
    
        if ($form->isSubmitted() && $form->isValid()) {
          $this->em->flush();
    
          return $this->json($commande,
          Response::HTTP_OK,
          [],
          ["groups" => "commandes:details"]);
        }
    
        $errors = $this->getFormErrors($form);
        return $this->json(
          $errors,
          Response::HTTP_BAD_REQUEST
        );
    }
}
