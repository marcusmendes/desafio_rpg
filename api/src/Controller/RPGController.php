<?php

namespace App\Controller;

use App\Services\RPGService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     */
    public function startRound(): JsonResponse
    {
        return $this->json($this->RPGService->startRound());
    }
}
