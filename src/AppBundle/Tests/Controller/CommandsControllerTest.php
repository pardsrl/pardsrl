<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandsControllerTest extends WebTestCase
{
    public function testPostreceivegit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/post-receive-git');
    }

}
