<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractBaseController
{
    public function register(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();
            // $this->fooAction($user);

            return $this->json(
                $user,
                Response::HTTP_CREATED,
                [],
                ['groups' => 'user_read']
            );
        }
        $errors = $this->getFormErrors($form);
        return $this->json(
            $errors,
            Response::HTTP_BAD_REQUEST
        );
    }
    // public function fooAction(User $user)
    // {
    //     $authenticationSuccessHandler = $this->container->get('lexik_jwt_authentication.handler.authentication_success');

    //     return $authenticationSuccessHandler->handleAuthenticationSuccess($user);
    // }
}
