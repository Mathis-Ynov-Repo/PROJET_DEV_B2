<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\PanierDetails;
use App\Form\PanierDetailsType;
use App\Form\PanierType;
use App\Repository\PanierDetailsRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractBaseController
{
    private $em;

    function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    /**
     * @Route("/paniers", name="liste_paniers", methods={"GET"})
     */
    public function list(PanierRepository $panierRepository) {
        $paniers = $panierRepository->findAll();

        return $this->json(
            $paniers,
            Response::HTTP_OK,
            [],
            ["groups" => ["plats:details", "panier:details"]]
        );
    }
    /**
     * @Route("/paniers/{id}", name="paniers_details", methods={"GET"})
     */
    public function detail(Panier $panier)
    {
        return $this->json(
        ['panier' => $panier], // données à sérialiser
        Response::HTTP_OK, // Code de réponse HTTP
        );
    }
    /**
     * @Route("/paniers", name="paniers_ajout", methods={"POST"})
     */
    public function create(
        Request $request
    ) {
        $data = json_decode($request->getContent(), true);
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($panier);
        $this->em->flush();

        return $this->json(
            $panier,
            Response::HTTP_CREATED,
            [],
            ["groups" => ["plats:details", "panier:details"]]
        );
        }
        $errors = $this->getFormErrors($form); 
        return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @Route("/paniers/{id}", name="paniers_patch", methods={"PATCH"})
     */
    public function patch(Panier $panier, Request $request)
    {
        return $this->update($request, $panier, false);
    }

    /**
     * @Route("/paniers/{id}", name="paniers_put", methods={"PUT"})
     */
    public function put(Panier $panier, Request $request)
    {
        return $this->update($request, $panier);
    }


    /**
     * @Route("/paniers/{id}", name="paniers_suppression", methods={"DELETE"})
     */
    public function delete(Panier $panier)
    {
        $this->em->remove($panier);
        $this->em->flush();

        return $this->json('ok');
    }

    /**
     * @Route("/paniers-details", name="liste_paniers_details", methods={"GET"})
     */
    public function listeDetails(Request $request, PanierDetailsRepository $panierDetailsRepository) {
        if ($request->query->has('panier')) {
            $id_panier = $request->query->get('panier');

            $panierDetail = $panierDetailsRepository->findBy(['panier' => $id_panier]);
        } else {
            $panierDetail = $panierDetailsRepository->findAll();
        }

        return $this->json(
            $panierDetail,
            Response::HTTP_OK,
            [],
            ["groups" => ["panier-details:details"]]
        );
    }
    /**
     * @Route("/paniers-details/{id}", name="paniers_details_details", methods={"GET"})
     */
    public function panierDetail(PanierDetails $panierDetail)
    {
        return $this->json(
        ['panierDetails' => $panierDetail], // données à sérialiser
        Response::HTTP_OK,
        [],
        ["groups" => ["panier-details:details"]] // Code de réponse HTTP
        );
    }

    /**
     * @Route("/paniers-details-single", name="paniers_details_details_platID", methods={"GET"})
     */
    public function panierDetailWithPlat(Request $request,PanierDetailsRepository $panierDetailsRepository)
    {
        if ($request->query->has('panier') && $request->query->has('plat')) {
            $id_panier = $request->query->get('panier');
            $id_plat = $request->query->get('plat');

            $panierDetail = $panierDetailsRepository->findOneBy(['panier' => $id_panier, 'plat' => $id_plat]);

            return $this->json(
                $panierDetail,
                Response::HTTP_OK,
                [],
                ["groups" => ["panier-details:details"]]
            );
        } else {
            return $this->json(Response::HTTP_NOT_FOUND);
        }




    }

    /**
     * @Route("/paniers-details", name="paniers_details_ajout", methods={"POST"})
     */
    public function createDetails(
        Request $request
    ) {
        $data = json_decode($request->getContent(), true);
        $panierDetail = new PanierDetails();
        $form = $this->createForm(PanierDetailsType::class, $panierDetail);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($panierDetail);
        $this->em->flush();

        return $this->json(
            $panierDetail,
            Response::HTTP_CREATED,
            [],
            ["groups" => ["panier-details:details"]]
        );
        }
        $errors = $this->getFormErrors($form); 
        return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @Route("/paniers-details/{id}", name="paniers_details_patch", methods={"PATCH"})
     */
    public function patchDetails(PanierDetails $panierDetail, Request $request)
    {
        return $this->updateDetails($request, $panierDetail, false);
    }

    /**
     * @Route("/paniers-details", name="paniers_details_patch", methods={"PATCH"})
     */
    public function patchDetailsWithPlat(PanierDetailsRepository $panierDetailsRepository, Request $request)
    {
        if ($request->query->has('plat') && $request->query->has('panier')) {
            $id_plat = $request->query->get('plat');
            $id_panier = $request->query->get('panier');

            $panierDetail = $panierDetailsRepository->findOneBy(['plat' => $id_plat, 'panier' => $id_panier]);

            return $this->updateDetails($request, $panierDetail, false);
        } else {
            return $this->json(
                Response::HTTP_NOT_FOUND
            );
        }
        
    }

    /**
     * @Route("/paniers-details/{id}", name="paniers_details_put", methods={"PUT"})
     */
    public function putDetails(PanierDetails $panierDetail, Request $request)
    {
        return $this->updateDetails($request, $panierDetail);
    }


    /**
     * @Route("/paniers-details/{id}", name="paniers_details_suppression", methods={"DELETE"})
     */
    public function deleteDetails(PanierDetails $panierDetail)
    {
        $this->em->remove($panierDetail);
        $this->em->flush();

        return $this->json('ok');
    }

    /**
     * @Route("/paniers-details-delete", name="paniers_details_suppression", methods={"DELETE"})
     */
    public function deleteAllDetails(Request $request, PanierDetailsRepository $panierDetailsRepository)
    {
        if($request->query->has('panier')) {
            $id_panier = $request->query->get('panier');

            $panierDetails = $panierDetailsRepository->findBy(['panier' => $id_panier]);

            foreach($panierDetails as $panierDetail) {
                $this->em->remove($panierDetail);
                $this->em->flush();
            }
            return $this->json('ok');
        }
        return $this->json(
            Response::HTTP_BAD_REQUEST
        );

    }

    /**
     * @Route("/paniers-details", name="paniers_details_suppression_platID", methods={"DELETE"})
     */
    public function deleteDetailsWithPlat(Request $request, PanierDetailsRepository $panierDetailsRepository)
    {
        if ($request->query->has('plat') && $request->query->has('panier')) {
            $id_plat = $request->query->get('plat');
            $id_panier = $request->query->get('panier');

            $panierDetail = $panierDetailsRepository->findOneBy(['plat' => $id_plat, 'panier' => $id_panier]);

            $this->em->remove($panierDetail);
            $this->em->flush();
    
            return $this->json('ok');
        } else {
            return $this->json(
                Response::HTTP_BAD_REQUEST
            );
        }

    }

    private function update(
        Request $request,
        Panier $panier,
        bool $clearMissing = true
      ) {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(PanierType::class, $panier);
    
        $form->submit($data, $clearMissing);
    
        if ($form->isSubmitted() && $form->isValid()) {
          $this->em->flush();
    
          return $this->json($panier,
          Response::HTTP_OK,
        );
        }
    
        $errors = $this->getFormErrors($form);
        return $this->json(
          $errors,
          Response::HTTP_BAD_REQUEST
        );
    }

    private function updateDetails(
        Request $request,
        PanierDetails $panierDetail,
        bool $clearMissing = true
      ) {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(PanierDetailsType::class, $panierDetail);
    
        $form->submit($data, $clearMissing);
    
        if ($form->isSubmitted() && $form->isValid()) {
          $this->em->flush();
    
          return $this->json($panierDetail,
          Response::HTTP_OK,
          [],
          ["groups" => ["panier-details:details"]]
        );
        }
    
        $errors = $this->getFormErrors($form);
        return $this->json(
          $errors,
          Response::HTTP_BAD_REQUEST
        );
    }
}