<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/new', name: 'user_new', methods: ['POST'])]
    public function addUser(Request $request, UserRepository $userRepository)
    {

        $users = $userRepository->findAll();
        if ($request->toArray()["mail"] == "" || $request->toArray()["mail"] == null)
            return new Response("Email is empty or not set", Response::HTTP_BAD_REQUEST);
        else {
            foreach ($users as $user) {
                if ($user->getMail() == $request->request->get("email")) {
                    return new Response("Email already exist", Response::HTTP_BAD_REQUEST);
                }
            }
        }

        if ($request->toArray()["lastname"] == "" || $request->toArray()["lastname"] == null)
            return new Response("Lastname is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->toArray()["firstname"] == "" || $request->toArray()["firstname"] == null)
            return new Response("Firstname is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->toArray()["password"] == "" || $request->toArray()["password"] == null)
            return new Response("Password is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->toArray()["birthdate"] == "" || $request->toArray()["birthdate"] == null)
            return new Response("Birthdate is empty or not set", Response::HTTP_BAD_REQUEST);

        $user = new User();
        $user->setFirstname($request->toArray()["firstname"]);
        $user->setLastname($request->toArray()["lastname"]);
        $user->setMail($request->toArray()["mail"]);
        $user->setPassword($request->toArray()["password"]);

        $dateInfo = explode("/",$request->toArray()["birthdate"]) ;

        $user->setBirthdate(Carbon::create( $dateInfo[0], $dateInfo[1], $dateInfo[2],0,0,0,"Europe/Paris") );
        if($user->isValid())  {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new Response(
                'User has been created succesfully',
                Response::HTTP_CREATED
            );
        } else return  new Response('User is not valid',Response::HTTP_BAD_REQUEST) ;
    }

    #[Route('/{id}', name: 'user_get', methods: ['GET'])]
    public function getUserByID(User $user): Response {
        if($user != null)
            return new JsonResponse(json_encode($user),Response::HTTP_OK);
        return new Response('No User exist with this ID', Response::HTTP_BAD_REQUEST) ;
    }
}
