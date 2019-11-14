<?php

namespace App\Controller;

use App\Exceptions\ApiException;
use App\Exceptions\ApiValidationException;
use App\Services\RPGService;
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
     * @param Request $request
     * @return JsonResponse
     * @throws ApiValidationException
     */
    public function turn(Request $request): JsonResponse
    {
        return $this->json($this->RPGService->startTurn($request));
    }
}
