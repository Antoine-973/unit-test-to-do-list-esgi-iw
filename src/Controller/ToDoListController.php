<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoListController extends AbstractController
{
    #[Route('/todo-list', name: 'to_do_list')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ToDoListController.php',
        ]);
    }

    #[Route('/user/{user_id}/todo-list', name: 'todo-list', methods:['GET'])]
    public function getUserTodoList(User $user): JsonResponse|Response
    {
        if($user == null)
            return new Response('User does not exist', Response::HTTP_BAD_REQUEST) ;
        if($user->getToDoList() == null)
            return new Response('Todo list is empty or do not exist', Response::HTTP_BAD_REQUEST) ;
        return new JsonResponse(json_encode($user->getToDoList()),Response::HTTP_BAD_REQUEST) ;
    }
}
