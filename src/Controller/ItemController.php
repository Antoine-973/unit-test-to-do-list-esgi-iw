<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    #[Route('/user/{user_id}/todo-list/addItem', name: 'item_new', methods:['POST'])]
    public function addItemInTodoList(User $user, Request $request): Response
    {
        if($user == null)  return new Response('User does not exist', Response::HTTP_BAD_REQUEST) ;
        if($user->getToDoList() == null) return new Response('Todo list is empty or do not exist', Response::HTTP_BAD_REQUEST) ;
        if($request->request->get('name') == null ) return new Response('Item name is not given', Response::HTTP_BAD_REQUEST) ;
    }
}
