<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NotificacionesControllerTest extends WebTestCase
{
    public function testNotificacionespersonales()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/notificacionesPersonales');
    }

    public function testNotificacionessistema()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/notificacionesSistema');
    }

}
