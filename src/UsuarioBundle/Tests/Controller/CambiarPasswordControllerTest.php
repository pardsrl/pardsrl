<?php

namespace UsuarioBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CambiarPasswordControllerTest extends WebTestCase
{
    public function testCambiarpassword()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cambiar-password');
    }

}
