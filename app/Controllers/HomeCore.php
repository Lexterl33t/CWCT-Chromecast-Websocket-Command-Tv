<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeCore
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response)
    {
        $response->getBody()->write($this->container->get('view')->render('home', ['title' => "Google chromecast TV commands"]));
        return $response;
    }
}