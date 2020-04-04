<?php

namespace App\Controller;

use App\Entity\Plats;
use App\Form\PlatsType;
use App\Repository\PlatsRepository;
use App\Repository\PlatsTypesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatsController extends AbstractBaseController
{
    private $em;

    function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    /**
     * @Route("/plats", name="liste_plats", methods={"GET"})
     */
    public function list(PlatsRepository $platsRepository) {
        $plats = $platsRepository->findAll();

        return $this->json(
            $plats,
            Response::HTTP_OK,
            [],
            ['groups' => 'plats:details']
        );
    }

    /**
     * @Route("/restaurants/{restaurant_id}/plats", name="restaurant_liste_plats", methods={"GET"})
     */
    public function listFromRestaurant(PlatsRepository $platsRepository, $restaurant_id) {
        $plats = $platsRepository->findBy(['restaurant'=> $restaurant_id]);

        return $this->json(
            $plats,
            Response::HTTP_OK,
            [],
            ['groups' => 'plats:details']
        );
    }


    /**
     * @Route("/plats/{id}", name="plats_details", methods={"GET"})
     */
    public function detail(Plats $plat)
    {
        return $this->json(
        ['plat' => $plat], // données à sérialiser
        Response::HTTP_OK, // Code de réponse HTTP
        [], // En-têtes
        ['groups' => 'plats:details'] // Contexte
        );
    }
    /**
     * @Route("/plats", name="plats_ajout", methods={"POST"})
     */
    public function create(
        Request $request
    ) {
        $data = json_decode($request->getContent(), true);
        $plats = new Plats();
        $form = $this->createForm(PlatsType::class, $plats);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($plats);
        $this->em->flush();

        return $this->json(
            $plats,
            Response::HTTP_CREATED,
            [],
            ["groups" => "plats:details"]
        );
        }
        $errors = $this->getFormErrors($form); 
        return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @Route("/plats/{id}", name="plats_patch", methods={"PATCH"})
     */
    public function patch(Plats $plat, Request $request)
    {
        return $this->update($request, $plat, false);
    }

    /**
     * @Route("/plats/{id}", name="plats_put", methods={"PUT"})
     */
    public function put(Plats $plat, Request $request)
    {
        return $this->update($request, $plat);
    }


    /**
     * @Route("/plats/{id}", name="plats_suppression", methods={"DELETE"})
     */
    public function delete(Plats $plat)
    {
        $this->em->remove($plat);
        $this->em->flush();

        return $this->json('ok');
    }

    /**
     * @Route("/plats-types", name="liste_plats_types", methods={"GET"})
     */
    public function listTypes(PlatsTypesRepository $platsTypesRepository) {
        $platsType = $platsTypesRepository->findAll();

        return $this->json(
            $platsType,
            Response::HTTP_OK,
            [],
            ["groups" => "platsTypes:details"]
        );
    }

    private function update(
        Request $request,
        Plats $plat,
        bool $clearMissing = true
      ) {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(PlatsType::class, $plat);
    
        $form->submit($data, $clearMissing);
    
        if ($form->isSubmitted() && $form->isValid()) {
          $this->em->flush();
    
          return $this->json($plat,
          Response::HTTP_OK,
          [],
          ["groups" => "plats:details"]);
        }
    
        $errors = $this->getFormErrors($form);
        return $this->json(
          $errors,
          Response::HTTP_BAD_REQUEST
        );
      }
}
