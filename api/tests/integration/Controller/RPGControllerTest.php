<?php

namespace App\Tests\integration\Controller;

use App\DataFixtures\CharacterFixtures;
use App\Entity\Round;
use App\Enum\TurnStep;
use App\Tests\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RPGControllerTest
 *
 * @package App\Tests\integration\Controller
 */
class RPGControllerTest extends ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->addFixture(new CharacterFixtures());
        $this->executeFixtures();
    }

    public function testDeveRetornarOsPersonagensDoRPG()
    {
        $this->client->request('GET', '/start');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);

        $this->assertIsArray($content);

        $this->assertArrayHasKey('round', $content);
        $this->assertArrayHasKey('characters', $content);

        $this->assertArrayHasKey('id', $content['round']);
        $this->assertArrayHasKey('name', $content['round']);
        $this->assertArrayHasKey('roundNumber', $content['round']);

        $this->assertArrayHasKey('human', $content['characters']);
        $this->assertArrayHasKey('orc', $content['characters']);

        $this->assertArrayHasKey('uniqueId', $content['characters']['human']);
        $this->assertArrayHasKey('uniqueId', $content['characters']['orc']);
    }

    public function testDeveRetornarErroDeValidacao()
    {
        $content = json_encode(
            [
                "round" => [
                    "idRound"    => "",
                    "number"     => "",
                    "characters" => [
                        "human" => [
                            "uniqueId" => "",
                        ],
                        "orc"   => [
                            "uniqueId" => "",
                        ],
                    ],
                ],
                "turn"  => [
                    "step"              => "",
                    "striker_uniqueId"  => null,
                    "defender_uniqueId" => null,
                ],
            ]
        );

        $this->client->request('POST', '/turn', [], [], [], $content);
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);

        $this->assertIsArray($content);
        $this->assertArrayHasKey('errors', $content);
        $this->assertNotEmpty($content['errors']);
    }

    public function testDeveRealizarAIniciativaERetornarQuemIniciaOAtaque()
    {
        $round = new Round();
        $round
            ->setName('Rodada 1')
            ->setRoundNumber(1);

        $this->entityManager->persist($round);
        $this->entityManager->flush();

        $content = json_encode(
            [
                "round" => [
                    "idRound"    => $round->getId(),
                    "number"     => $round->getRoundNumber(),
                    "characters" => [
                        "human" => [
                            "uniqueId" => "c_humano",
                        ],
                        "orc"   => [
                            "uniqueId" => "c_orc",
                        ],
                    ],
                ],
                "turn"  => [
                    "step"              => TurnStep::INIATIVE,
                    "striker_uniqueId"  => null,
                    "defender_uniqueId" => null,
                ],
            ]
        );

        $this->client->request('POST', '/turn', [], [], [], $content);
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);

        $this->assertIsArray($content);

        $this->assertArrayHasKey('nextStep', $content);
        $this->assertEquals(TurnStep::ATTACK, $content['nextStep']);

        $this->assertArrayHasKey('strikerUniqueId', $content);
        $this->assertArrayHasKey('defenderUniqueId', $content);

        $this->assertArrayHasKey('winner', $content);

        $this->assertArrayHasKey('turnRounds', $content);

        $turnRounds = $content['turnRounds'];

        $this->assertIsArray($turnRounds);
        $this->assertNotEmpty($turnRounds);

        $this->assertArrayHasKey('characterStriker', $turnRounds[0]);
        $this->assertArrayHasKey('uniqueId', $turnRounds[0]['characterStriker']);

        $this->assertArrayHasKey('characterDefender', $turnRounds[0]);
        $this->assertArrayHasKey('uniqueId', $turnRounds[0]['characterDefender']);

        $this->assertArrayHasKey('amountLifeStriker', $turnRounds[0]);
        $this->assertArrayHasKey('amountLifeDefender', $turnRounds[0]);
        $this->assertArrayHasKey('damage', $turnRounds[0]);
    }

    public function testDeveRealizarOAtaqueEReiniciarAInciativa()
    {
        $round = new Round();
        $round
            ->setName('Rodada 1')
            ->setRoundNumber(1);

        $this->entityManager->persist($round);
        $this->entityManager->flush();

        $content = json_encode(
            [
                "round" => [
                    "idRound"    => $round->getId(),
                    "number"     => $round->getRoundNumber(),
                    "characters" => [
                        "human" => [
                            "uniqueId" => "c_humano",
                        ],
                        "orc"   => [
                            "uniqueId" => "c_orc",
                        ],
                    ],
                ],
                "turn"  => [
                    "step"              => TurnStep::ATTACK,
                    "striker_uniqueId"  => 'c_humano',
                    "defender_uniqueId" => 'c_orc',
                ],
            ]
        );

        $this->client->request('POST', '/turn', [], [], [], $content);
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);

        $this->assertIsArray($content);

        $this->assertEquals(TurnStep::INIATIVE, $content['nextStep']);
        $this->assertGreaterThanOrEqual(0, $content['turnRounds'][0]['damage']);
    }
}
