<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Entity\RestaurantTypes;
use App\Form\RestaurantType;
use App\Repository\RestaurantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantsController extends AbstractBaseController
{
    private $em;

    function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    
    /**
     * @Route("/restaurants", name="restaurants_liste", methods={"GET"})
     */
    public function list(RestaurantsRepository $restaurantsRepository) {
        $restaurants = $restaurantsRepository->findAll();

        return $this->json(
            $restaurants,
            Response::HTTP_OK,
            [],
            ['groups' => 'restaurants:details']
        );
    }
    /**
     * @Route("/restaurants/{id}", name="restaurants_details", methods={"GET"})
     */
    public function detail(Restaurants $restaurant)
    {
        return $this->json(
        ['restaurant' => $restaurant], // données à sérialiser
        Response::HTTP_OK, // Code de réponse HTTP
        [], // En-têtes
        ['groups' => 'restaurants:details'] // Contexte
        );
    }
    /**
     * @Route("/restaurants", name="restaurants_ajout", methods={"POST"})
     */
    public function create(Request $request) {
        $data = json_decode($request->getContent(), true);
        $restaurant = new Restaurants();
        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($restaurant);
        $this->em->flush();

        return $this->json(
            $restaurant,
            Response::HTTP_CREATED,
            [],
            ["groups" => "restaurants:details"]
        );
        }
        $errors = $this->getFormErrors($form); 
        return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @Route("/restaurants/{id}", name="restaurants_patch", methods={"PATCH"})
     */
    public function patch(Restaurants $restaurant, Request $request)
    {
        return $this->update($request, $restaurant, false);
    }

    /**
     * @Route("/restaurants/{id}", name="restaurants_put", methods={"PUT"})
     */
    public function put(Restaurants $restaurant, Request $request)
    {
        return $this->update($request, $restaurant);
    }

    /**
     * @Route("/restaurants/{id}", name="restaurants_suppression", methods={"DELETE"})
     */
    public function delete(Restaurants $restaurant)
    {
        $this->em->remove($restaurant);
        $this->em->flush();

        return $this->json('ok');
    }
    private function update(
        Request $request,
        Restaurants $restaurant,
        bool $clearMissing = true
      ) {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(RestaurantType::class, $restaurant);
    
        $form->submit($data, $clearMissing);
    
        if ($form->isSubmitted() && $form->isValid()) {
          $this->em->flush();
    
          return $this->json($restaurant,
          Response::HTTP_OK,
          [],
          ["groups" => "restaurants:details"]);
        }
    
        $errors = $this->getFormErrors($form);
        return $this->json(
          $errors,
          Response::HTTP_BAD_REQUEST
        );
      }
}
