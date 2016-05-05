<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjaxControllerTest extends WebTestCase
{
    public function testDatosenvivo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'ajax/datos_en_vivo');
    }

}
