<?php

namespace App\Controller;

use App\Entity\ToDoList;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoListController extends AbstractController
{

    #[Route('/user/{user_id}/todo-list', name: 'todo-list_get', methods:['GET'])]
    public function getUserTodoList(User $user): JsonResponse|Response
    {
        if($user == null)
            return new Response('User does not exist', Response::HTTP_BAD_REQUEST) ;
        if($user->getToDoList() == null)
            return new Response('Todo list is empty or do not exist', Response::HTTP_BAD_REQUEST) ;
        return new JsonResponse(json_encode($user->getToDoList()),Response::HTTP_BAD_REQUEST) ;
    }

    #[Route('user/{user_id}/todo-list/new', name: 'todo-list_new', methods:['POST'])]
    public function createUserTodoList(User $user, Request $request) {
      if($user == null)  return new Response('User does not exist', Response::HTTP_BAD_REQUEST) ;
      if($user->getToDoList() != null)  return new Response('Todo list already exist', Response::HTTP_BAD_REQUEST) ;
      if($request->request->get("name") == "" || null ) return  new Response("Todo list name is not set", Response::HTTP_BAD_REQUEST);
      $user->setToDoList(new ToDoList($request->request->get("name"))) ;
      $em = $this->getDoctrine()->getManager();
      $em->persit($user) ;
      $em->flush() ;
      return new JsonResponse(json_encode($user),Response::HTTP_CREATED) ;
    }
}
