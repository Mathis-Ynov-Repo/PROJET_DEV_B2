<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Repository\FeedbackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractBaseController
{
    private $em;

    function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    /**
     * @Route("/feedbacks", name="feedback_list", methods={"GET"})
     */
    public function list(FeedbackRepository $feedbackRepository) {
        $feedback = $feedbackRepository->findAll();

        return $this->json(
            $feedback,
            Response::HTTP_OK,
        );
    }
    /**
     * @Route("/feedbacks/{id}", name="feedback_details", methods={"GET"})
     */
    public function detail(Feedback $feedback)
    {
        return $this->json(
        ['feedback' => $feedback], // données à sérialiser
        Response::HTTP_OK, // Code de réponse HTTP
        [], // En-têtes
        );
    }
    /**
     * @Route("/feedbacks", name="feedbacks_ajout", methods={"POST"})
     */
    public function create(
        Request $request
    ) {
        $data = json_decode($request->getContent(), true);
        $feedbacks = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedbacks);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($feedbacks);
        $this->em->flush();

        return $this->json(
            $feedbacks,
            Response::HTTP_CREATED,
        );
        }
        $errors = $this->getFormErrors($form); 
        return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @Route("/feedbacks/{id}", name="feedbacks_patch", methods={"PATCH"})
     */
    public function patch(Feedback $feedback, Request $request)
    {
        return $this->update($request, $feedback, false);
    }

    /**
     * @Route("/feedbacks/{id}", name="feedbacks_put", methods={"PUT"})
     */
    public function put(Feedback $feedback, Request $request)
    {
        return $this->update($request, $feedback);
    }


    /**
     * @Route("/feedbacks/{id}", name="feedback_suppression", methods={"DELETE"})
     */
    public function delete(Feedback $feedback)
    {
        $this->em->remove($feedback);
        $this->em->flush();

        return $this->json('ok');
    }

    private function update(
        Request $request,
        Feedback $feedback,
        bool $clearMissing = true
      ) {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(FeedbackType::class, $feedback);
    
        $form->submit($data, $clearMissing);
    
        if ($form->isSubmitted() && $form->isValid()) {
          $this->em->flush();
    
          return $this->json($feedback,
          Response::HTTP_OK,
        );
        }
    
        $errors = $this->getFormErrors($form);
        return $this->json(
          $errors,
          Response::HTTP_BAD_REQUEST
        );
      }
}
