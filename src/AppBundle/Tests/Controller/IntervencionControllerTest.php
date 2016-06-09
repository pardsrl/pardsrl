<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IntervencionControllerTest extends WebTestCase
{
    public function testNueva()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nueva');
    }

}
