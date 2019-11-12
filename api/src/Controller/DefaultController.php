<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * Metodo retornado pelo rota padrao
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'API desafio RPG'
        ]);
    }
}
