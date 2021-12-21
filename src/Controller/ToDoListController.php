<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/user/{user_id}/todo-list', name: 'todo-list')]
    public function getUserTodoList(User $user)
    {
        var_dump( $user->getToDoList() );
    }
}
