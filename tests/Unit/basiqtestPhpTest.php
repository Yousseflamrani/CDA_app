<?php

namespace App\Tests\App\tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class basiqtestPhpTes extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/admin/article/');
        $this->assertResponseRedirects();

       // $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/article/new');
        

       // $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertResponseRedirects(); 

       
    }

   
}
