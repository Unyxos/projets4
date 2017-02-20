<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testAfficherprofil()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/profil');
    }

    public function testAffichermonprofil()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'mon-profil');
    }

    public function testModifiermonprofil()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'modifier-profil');
    }

}
