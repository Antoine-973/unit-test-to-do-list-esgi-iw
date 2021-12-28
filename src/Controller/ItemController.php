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
        if(strlen($request->toArray()['content']) > 1000 ) return new Response('Content is to big', Response::HTTP_BAD_REQUEST) ;
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository(Item::class);
        $currentItems = $items->findBy(['toDoList' => $user->getToDoList()->getId()]);

        $lastItemDateTime = end($currentItems)->getCreatedAt() ;
        $diff = $lastItemDateTime->diff(new \DateTime()) ;
        if($diff->i < 1)
            return new Response("Attend encore un peu...", Response::HTTP_BAD_REQUEST) ;
        foreach ($currentItems as $i) {
            if($i->getName() == $request->toArray()['name'])
                return new Response('Item name already exist', Response::HTTP_BAD_REQUEST) ;
        }

        if(count($currentItems) == 10)
            return new Response("Limite d'item atteinte. Vous ne pouvez pas en ajouter ", Response::HTTP_BAD_REQUEST) ;

        $item = new Item();
        $item->setName($request->toArray()["name"]);
        $item->setContent($request->toArray()["content"]);

        $item->setToDoList($user->getToDoList());


        $em->persist($item) ;
        $em->flush() ;


        if(count($currentItems) == 7) {
            throw new \Exception("Envoie du mail. Vous avez 8 élements dans la todolist. Vous pouvez en ajouter encore 2");
        }
        return new Response(
            "Item {$item->getName()} has been added succesfully to the toDoList {$user->getToDoList()->getName()} of {$user->getFirstname()} {$user->getLastname()}",
            Response::HTTP_CREATED
        );
    }
}
