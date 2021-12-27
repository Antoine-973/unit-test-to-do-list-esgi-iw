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
        if($request->toArray()["name"] == null ) return new Response('Item name is not given', Response::HTTP_BAD_REQUEST) ;


        $item = new Item();
        $item->setName($request->toArray()["name"]);
        $item->setContent($request->toArray()["content"]);

        $item->setToDoList($user->getToDoList());

        $em = $this->getDoctrine()->getManager();
        $em->persist($item) ;
        $em->flush() ;

        $items = $em->getRepository(Item::class);
        $currentItems = $items->findBy(['toDoList' => $user->getToDoList()->getId()]);
        if(count($currentItems) == 8) {
            throw new \Exception("Envoie du mail. Vous avez 8 élements dans la todolist. Vous pouvez en ajouter encore 2");
        }
        return new Response(
            "Item {$item->getName()} has been added succesfully to the toDoList {$user->getToDoList()->getName()} of {$user->getFirstname()} {$user->getLastname()}",
            Response::HTTP_CREATED
        );
    }
}
