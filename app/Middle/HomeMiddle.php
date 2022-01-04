<?php

namespace App\Middle;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeMiddle
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $response->getBody()->write('Before');
        $response = $next($request, $response);
        return $response;
    }
}