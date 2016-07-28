<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NovedadControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');
    }

    public function testNueva()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nueva');
    }

    public function testEditar()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editar');
    }

}
