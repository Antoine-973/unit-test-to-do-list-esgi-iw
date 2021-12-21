<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Carbon\Doctrine\DateTimeImmutableType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/new', name: 'user_new', methods: ['POST'])]
    public function addUser(Request $request, UserRepository $userRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $userRepository->findAll();

        if ($request->get("email") == "" || $request->get("email") == null)
            return new Response("Email is empty or not set", Response::HTTP_BAD_REQUEST);

        else {
            foreach ($users as $user) {
                if ($user->getMail() == $request->get("email")) {
                    return new Response("Email already exist", Response::HTTP_BAD_REQUEST);
                }
            }
        }

        if ($request->get("lastname") == "" || $request->get("lastname") == null)
            return new Response("Lastname is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->get("firstname") == "" || $request->get("firstname") == null)
            return new Response("Firstname is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->get("password") == "" || $request->get("password") == null)
            return new Response("password is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->get("birthdate") == "" || $request->get("birthdate") == null)
            return new Response("birthdate is empty or not set", Response::HTTP_BAD_REQUEST);

        $user = new User();
        $user->setFirstname($request->get("firstname"));
        $user->setLastname($request->get("lastname"));
        $user->setMail($request->get("email"));
        $user->setPassword($request->get('password'));
        $user->setBirthdate(new DateTimeImmutableType());
        //if($user->isValid())  {
        $em->persit($user);
        $em->flush();
        return new Response(
            'User has been created succesfully',
            Response::HTTP_CREATED
        );
        //}
    }

    #[Route('/user/{user_id}', name: 'user_get', methods: ['GET'])]
    public function getUserByID(User $user) {
        if($user != null)
            return new JsonResponse(json_encode($user),Response::HTTP_OK) ;
        return new Response('user id is invalid', Response::HTTP_BAD_REQUEST) ;
    }
}
