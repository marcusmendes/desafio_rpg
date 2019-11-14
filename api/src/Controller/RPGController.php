<?php

namespace App\Controller;

use App\Exceptions\ApiException;
use App\Exceptions\ApiValidationException;
use App\Services\RPGService;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RPGController
 * @package App\Controller
 */
class RPGController extends AbstractController
{
    /**
     * @var RPGService
     */
    private $RPGService;

    /**
     * RPGController constructor.
     * @param RPGService $RPGService
     */
    public function __construct(RPGService $RPGService)
    {
        $this->RPGService = $RPGService;
    }

    /**
     * Inicia a rodada
     *
     * @Get(
     *     path="/start",
     *     summary="Inicia a rodada",
     *     description="Rota utilizada para iniciar a rodada",
     *     @Response(
     *          response="200",
     *          description="Cria a rodada e retorna os personagens",
     *          @MediaType(
     *              mediaType="application/json",
     *              @Schema(
     *                  type="object",
     *                  @Property(
     *                     property="round",
     *                     ref="#/components/schemas/Round",
     *                  ),
     *                  @Property(
     *                      property="characters",
     *                      type="object",
     *                      @Property(
     *                          property="human",
     *                          ref="#/components/schemas/Character"
     *                      ),
     *                      @Property(
     *                          property="orc",
     *                          ref="#/components/schemas/Character"
     *                      ),
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     * @return JsonResponse
     * @throws ApiException
     */
    public function startRound(): JsonResponse
    {
        return $this->json($this->RPGService->startRound());
    }

    /**
     * Inicia o turno
     *
     * @Post(
     *     path="/turn",
     *     summary="Inicia o turno da rodada",
     *     description="Rota utilizada para iniciar o turno de uma rodada",
     *     @RequestBody(
     *          required=true,
     *          @MediaType(
     *              mediaType="application/json",
     *              @Schema(
     *                  type="object",
     *                  @Property(
     *                      property="round",
     *                      type="object",
     *                      @Property(property="idRound", type="integer", example="1"),
     *                      @Property(property="number", type="integer", example="1"),
     *                      @Property(
     *                          property="characters",
     *                          type="object",
     *                          @Property(
     *                              property="human",
     *                              type="object",
     *                              @Property(property="uniqueId", type="string", example="c_humano")
     *                          ),
     *                          @Property(
     *                              property="orc",
     *                              type="object",
     *                              @Property(property="uniqueId", type="string", example="c_orc")
     *                          ),
     *                      ),
     *                  ),
     *                  @Property(
     *                      property="turn",
     *                      type="object",
     *                      @Property(property="step", type="string", example="ATTACK"),
     *                      @Property(property="striker_uniqueId", type="string", example="c_humano"),
     *                      @Property(property="defender_uniqueId", type="string", example="c_orc"),
     *                  )
     *              )
     *          )
     *      ),
     *     @Response(
     *          response="200",
     *          description="Retorna os dados do turno",
     *          @MediaType(
     *              mediaType="application/json",
     *              @Schema(
     *                  type="object",
     *                  @Property(property="step", type="string", example="ATTACK"),
     *                  @Property(
     *                      property="turnRound",
     *                      type="object",
     *                      @Property(property="round", ref="#/components/schemas/Round"),
     *                      @Property(property="characterStriker", ref="#/components/schemas/Character"),
     *                      @Property(property="characterDefender", ref="#/components/schemas/Character"),
     *                      @Property(property="amountLifeStriker", type="integer", example="12"),
     *                      @Property(property="amountLifeDefender", type="integer", example="20"),
     *                      @Property(property="damage", type="integer", example="5"),
     *                  ),
     *              )
     *          )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiValidationException
     */
    public function turn(Request $request): JsonResponse
    {
        return $this->json($this->RPGService->startTurn($request));
    }
}
