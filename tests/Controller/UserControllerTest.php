<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUserCreation(): void
    {
        $client = static::createClient();
        $client->request('POST', '/user/new',array(),array(),array("CONTENT_TYPE"=> "application/json"),json_encode(array(
            "firstname"=>"TestCreateAUser",
            "lastname"=>"ByWebTestCase",
            "password"=>"123soleil",
            "email"=>"test@gmail.com",
            "birthdate"=>"2000/10/05"
        )));

        $this->assertResponseIsSuccessful();
    }
}
