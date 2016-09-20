<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MensajesControllerTest extends WebTestCase
{
    public function testNotificaciones()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/notificaciones');
    }

    public function testMailbox()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/mailbox');
    }

}
