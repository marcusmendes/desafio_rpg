<?php

namespace App\Controller;

use OpenApi\Annotations\Get;
use OpenApi\Annotations\Info;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use OpenApi\Annotations\Server;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * Metodo retornado pelo rota padrao
     *
     * @Info(
     *     title="API Desafio RPG",
     *     version="1.0.0",
     * )
     *
     * @Server(
     *     url="http://localhost:8000"
     * )
     *
     * @Get(
     *     path="/",
     *     summary="Rotão padrão do projeto",
     *     description="Rotão padrão do projeto",
     *     @\OpenApi\Annotations\Response(
     *          response="200",
     *          description="sucesso",
     *          @MediaType(
     *              mediaType="application/json",
     *              @Schema(
     *                  type="object",
     *                  @Property(property="message", type="string", example="API desafio RPG")
     *              )
     *          )
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'API desafio RPG'
        ]);
    }

    /**
     * Renderiza a página da documentação
     *
     * @return Response
     */
    public function apidoc(): Response
    {
        return $this->render('index.html.twig');
    }
}
