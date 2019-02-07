<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DemandeControllerTest extends WebTestCase
{
    public function testDemande()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/demande');
    }

}
