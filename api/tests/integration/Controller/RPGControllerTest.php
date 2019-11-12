<?php

namespace App\Tests\integration\Controller;

use App\DataFixtures\CharacterFixtures;
use App\Tests\ApiTestCase;

/**
 * Class RPGControllerTest
 * @package App\Tests\integration\Controller
 */
class RPGControllerTest extends ApiTestCase
{
    public function testDeveRetornarOsPersonagensDoRPG()
    {
        $this->addFixture(new CharacterFixtures());
        $this->executeFixtures();

        $this->client->request('GET', '/start');
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $expected = '{"human":{"uniqueId":"c_humano","name":"Humano","amountLife":12,"amountStrength":1,"amountAgility":2,"weapon":{"uniqueId":"w_espada longa","name":"Espada Longa","amountAttack":2,"amountDefense":1,"amountDamage":0}},"orc":{"uniqueId":"c_orc","name":"Orc","amountLife":20,"amountStrength":2,"amountAgility":0,"weapon":{"uniqueId":"w_clava de madeira","name":"Clava de Madeira","amountAttack":1,"amountDefense":0,"amountDamage":0}}}';

        $content = $response->getContent();

        $this->assertJsonStringEqualsJsonString($expected, $content);
    }
}
