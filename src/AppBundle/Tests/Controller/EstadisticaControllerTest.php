<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EstadisticaControllerTest extends WebTestCase
{
    public function testOperacionesporequipo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'operaciones_por_equipo');
    }

    public function testOperacionesporyacimiento()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'operaciones_por_yacimiento');
    }

    public function testPromedioscanoshora()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'promedios_canos_hora');
    }

    public function testFactortiempoutil()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'factor_tiempo_util');
    }

}
