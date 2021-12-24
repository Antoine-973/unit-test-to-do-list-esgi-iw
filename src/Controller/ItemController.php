<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\ToDoList;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class ItemController extends AbstractController
{
    #[Route('/{user}/todo-list/addItem', name: 'item_new', methods:['POST'])]
    public function addItemInTodoList(User $user, Request $request): Response
    {
        if($user == null)  return new Response('User does not exist', Response::HTTP_BAD_REQUEST) ;
        if($user->getToDoList() == null) return new Response('Todo list is empty or do not exist', Response::HTTP_BAD_REQUEST) ;
        if($request->query->get('name') == null ) return new Response('Item name is not given', Response::HTTP_BAD_REQUEST) ;

        $item = new Item();
        $item->setName($request->query->get("name"));
        $item->setContent($request->query->get("content"));
        $item->setToDoList($user->getToDoList());

        $em = $this->getDoctrine()->getManager();
        $em->persist($item) ;
        $em->flush() ;
        return new Response(
            "Item {$item->getName()} has been added succesfully to the toDoList {$user->getToDoList()->getName()} of {$user->getFirstname()} {$user->getLastname()}",
            Response::HTTP_CREATED
        );
    }
}
