<?php

namespace App\Tests\integration\Controller;

use App\DataFixtures\CharacterFixtures;
use App\Tests\ApiTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

/**
 * Class RPGControllerTest
 * @package App\Tests\integration\Controller
 */
class RPGControllerTest extends ApiTestCase
{
    use FixturesTrait;

    public function testDeveRetornarOsPersonagensDoRPG()
    {
        $this->loadFixtures([
            CharacterFixtures::class
        ]);

        $this->client->request('GET', '/start');
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $expected = '{"human":{"uniqueId":1000,"name":"Humano","amountLife":12,"amountStrength":1,"amountAgility":2,"weapon":{"id":1,"name":"Espada Longa","amountAttack":2,"amountDefense":1,"amountDamage":0}},"orc":{"uniqueId":1001,"name":"Orc","amountLife":20,"amountStrength":2,"amountAgility":0,"weapon":{"id":2,"name":"Clava de Madeira","amountAttack":1,"amountDefense":0,"amountDamage":0}}}';

        $content = $response->getContent();

        $this->assertJsonStringEqualsJsonString($expected, $content);
    }
}
