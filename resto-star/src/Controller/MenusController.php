<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenusController extends AbstractBaseController
{
    // private $em;

    // function __construct(EntityManagerInterface $em) {
    //     $this->em = $em;
    // }
    // /**
    //  * @Route("/menus", name="liste_menus", methods={"GET"})
    //  */
    // public function list(MenuRepository $menusRepository) {
    //     $plats = $menusRepository->findAll();

    //     return $this->json(
    //         $plats,
    //         Response::HTTP_OK,
    //         [],
    //         ['groups' => 'menus:details']
    //     );
    // }

    //     /**
    //  * @Route("/{restaurant_id}/menus", name="liste_menus", methods={"GET"})
    //  */
    // public function listFromRestaurant(MenuRepository $menusRepository, Request $request, $restaurant_id) {
    //     $plats = $menusRepository->findBy(['restaurant'=> $restaurant_id]);

    //     return $this->json(
    //         $plats,
    //         Response::HTTP_OK,
    //         [],
    //         ['groups' => 'menus:details']
    //     );
    // }

    // /**
    //  * @Route("/menus/{id}", name="menus_details", methods={"GET"})
    //  */
    // public function detail(Menu $menu)
    // {
    //     return $this->json(
    //     ['menu' => $menu], // données à sérialiser
    //     Response::HTTP_OK, // Code de réponse HTTP
    //     [], // En-têtes
    //     ['groups' => 'menus:details'] // Contexte
    //     );
    // }

    // /**
    //  * @Route("/menus", name="menus_ajout", methods={"POST"})
    //  */
    // public function create(
    //     Request $request
    // ) {
    //     $data = json_decode($request->getContent(), true);
    //     $menu = new Menu();
    //     $form = $this->createForm(MenuType::class, $menu);

    //     $form->submit($data);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //     $this->em->persist($menu);
    //     $this->em->flush();

    //     return $this->json(
    //         $menu,
    //         Response::HTTP_CREATED,
    //         [],
    //         ["groups" => "menus:details"]
    //     );
    //     }
    //     $errors = $this->getFormErrors($form); 
    //     return $this->json(
    //     $errors,
    //     Response::HTTP_BAD_REQUEST
    //     );
    // }

    // /**
    //  * @Route("/menus/{id}", name="menus_patch", methods={"PATCH"})
    //  */
    // public function patch(Menu $menu, Request $request)
    // {
    //     return $this->update($request, $menu, false);
    // }

    // /**
    //  * @Route("/menus/{id}", name="menus_put", methods={"PUT"})
    //  */
    // public function put(Menu $menu, Request $request)
    // {
    //     return $this->update($request, $menu);
    // }

    // /**
    //  * @Route("/menus/{id}", name="menus_suppression", methods={"DELETE"})
    //  */
    // public function delete(Menu $menu)
    // {
    //     $this->em->remove($menu);
    //     $this->em->flush();

    //     return $this->json('ok');
    // }

    // private function update(
    //     Request $request,
    //     Menu $menu,
    //     bool $clearMissing = true
    //   ) {
    //     $data = json_decode($request->getContent(), true);
    //     $form = $this->createForm(MenuType::class, $menu);
    
    //     $form->submit($data, $clearMissing);
    
    //     if ($form->isSubmitted() && $form->isValid()) {
    //       $this->em->flush();
    
    //       return $this->json($menu,
    //       Response::HTTP_OK,
    //       [],
    //       ["groups" => "menus:details"]);
    //     }
    
    //     $errors = $this->getFormErrors($form);
    //     return $this->json(
    //       $errors,
    //       Response::HTTP_BAD_REQUEST
    //     );
    // }
}
