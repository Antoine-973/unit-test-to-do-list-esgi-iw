<?php


namespace App\Tests\Entity;

use App\Entity\ToDoList;
use App\Entity\User;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class ToDoListTest extends TestCase
{
    private ToDoList $toDoList;
    private User $user;

    protected function setUp(): void
    {
        /* Création de la todolist */
        $this->toDoList = new ToDoList('ToDoList 1');

        /* Création du user */
        $this->user = new User();
        $this->user->setFirstname('Antoine');
        $this->user->setLastname('Saunier');
        $this->user->setMail('antoine.saunier@test.fr');
        $this->user->setPassword('password');
        $dateInfo = explode("/", '2000/08/23');
        $this->user->setBirthdate(Carbon::create($dateInfo[0], $dateInfo[1], $dateInfo[2], 0, 0, 0, "Europe/Paris"));
        $this->user->setToDoList($this->toDoList);
    }

    public function testCheckName()
    {
        $this->assertEquals('ToDoList 1',$this->toDoList->getName());
    }

    public function testCheckUser()
    {
        $this->assertTrue($this->user->isValid());
        $this->assertEquals($this->toDoList,$this->user->getToDoList());
    }

    public function testDoubleToDoList()
    {
        /* Création de la seconde todolist */
        $tdl2 = $this->toDoList = new ToDoList('ToDoList 2');

        $this->assertTrue($this->user->isValid());
        $this->assertEquals(null,$this->user->setToDoList($tdl2));
    }
}