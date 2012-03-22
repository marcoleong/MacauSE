<?php

namespace MacauSE\DirectoryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/en/directory/');

        $this->assertTrue($crawler->filter('html:contains("Home")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Directory")')->count() > 0);
		
       	//Test presents of language bar
		
    }

	public function testTranslationSlug()
	{
		
	}
}
