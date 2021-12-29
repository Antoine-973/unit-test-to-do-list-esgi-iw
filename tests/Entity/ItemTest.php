<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\ToDoList;
use App\Entity\Item;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    private User $user;
    private Item $item;

    protected function setUp(): void
    {
        //Create User
        $this->user = new User();
        $this->user->setFirstname('Antoine');
        $this->user->setLastname('Saunier');
        $this->user->setMail('antoine.saunier@test.fr');
        $this->user->setPassword('password');
        $dateInfo = explode("/", '2000/08/23');
        $this->user->setBirthdate(Carbon::create($dateInfo[0], $dateInfo[1], $dateInfo[2], 0, 0, 0, "Europe/Paris"));
        
        // Create ToDoList
        $this->user->setToDoList(new ToDoList("MaToDoList"));

        // Create Item
        $this->item = new Item();
        $this->item->setName("Les plus gros bgs de l'univers");
        $this->item->setContent("Antoine, Arthur et Alexandre");
        $this->item->setCreatedAt(new \DateTime());
        $this->item->setToDoList($this->user->getToDoList());
        parent::setUp();
    }

    public function testItemIsValidNominal()
    {
        $this->assertTrue($this->item->isValid());
    }

    public function testNotValidDueToEmptyName()
    {
        $this->item->setName('');
        $this->assertFalse($this->item->isValid());
    }

    public function testNotValidDueToTooLongContent()
    {
        $this->item->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id arcu ut odio porttitor
        ultrices vitae et ipsum. Donec quis leo posuere diam egestas consectetur a a dolor. Ut eu pulvinar leo. Sed at leo vitae
        sapien accumsan faucibus. Duis vitae consectetur mi. Integer consequat nisl at enim gravida, sed dignissim ante volutpat.
        Curabitur mauris metus, fringilla et ligula vitae, gravida convallis lacus. Sed viverra felis eu orci facilisis, ultrices
        varius purus accumsan. Etiam feugiat nisl felis. Pellentesque accumsan arcu non vulputate porttitor. Integer at eros cursus 
        urna tincidunt pretium.
        Fusce finibus, arcu ut elementum finibus, libero neque facilisis diam, nec convallis magna nunc vitae arcu. Sed aliquam eros
        et eros tristique, eu malesuada ante convallis. Etiam eget odio varius, eleifend neque dictum, pharetra lectus. Mauris libero
        sem, consequat sed elit a, aliquam rhoncus mi. Proin molestie dolor lectus, vitae interdum turpis mollis quis. Cras sagittis
        diam urna. Lorem augue.');
        $this->assertFalse($this->item->isValid());
    }

    public function testNotValidDueToItemDontHaveToDoList(){
        $this->item->setToDoList(null);
        $this->assertFalse($this->item->isValid());
    }


}