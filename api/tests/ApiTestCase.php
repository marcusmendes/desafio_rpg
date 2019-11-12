<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ApiTestCase
 * @package App\Tests
 */
class ApiTestCase extends WebTestCase
{
    /**
     * @var KernelBrowser $client
     */
    protected $client;

    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        $container = $this->client->getContainer();
        $doctrine = $container->get('doctrine');
        $this->entityManager = $doctrine->getManager();
    }
}
