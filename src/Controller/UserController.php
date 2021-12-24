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

        if ($request->query->get("email") == "" || $request->query->get("email") == null)
            return new Response("Email is empty or not set", Response::HTTP_BAD_REQUEST);

        else {
            foreach ($users as $user) {
                if ($user->getMail() == $request->request->get("email")) {
                    return new Response("Email already exist", Response::HTTP_BAD_REQUEST);
                }
            }
        }

        if ($request->query->get("lastname") == "" || $request->query->get("lastname") == null)
            return new Response("Lastname is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->query->get("firstname") == "" || $request->query->get("firstname") == null)
            return new Response("Firstname is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->query->get("password") == "" || $request->query->get("password") == null)
            return new Response("password is empty or not set", Response::HTTP_BAD_REQUEST);

        if ($request->query->get("birthdate") == "" || $request->query->get("birthdate") == null)
            return new Response("birthdate is empty or not set", Response::HTTP_BAD_REQUEST);

        $user = new User();
        $user->setFirstname($request->query->get("firstname"));
        $user->setLastname($request->query->get("lastname"));
        $user->setMail($request->query->get("email"));
        $user->setPassword($request->query->get('password'));

        $dateInfo = explode("/",$request->query->get("birthdate")) ;

        $user->setBirthdate(Carbon::create( $dateInfo[0], $dateInfo[1], $dateInfo[2],0,0,0,"Europe/Paris") );
        if($user->isValid())  {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new Response(
                'User has been created succesfully',
                Response::HTTP_CREATED
            );
        } else return  new Response('user is not valid',Response::HTTP_BAD_REQUEST) ;
    }

    #[Route('/{user_id}', name: 'user_get', methods: ['GET'])]
    public function getUserByID(User $user) {
        if($user != null)
            return new JsonResponse(json_encode($user),Response::HTTP_OK) ;
        return new Response('user id is invalid', Response::HTTP_BAD_REQUEST) ;
    }
}
