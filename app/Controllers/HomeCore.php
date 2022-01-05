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

    public function save_remote(Request $request, Response $response, $args)
    {
        $params = filter_var_array($request->getParsedBody());

        if(isset($_COOKIE['configuration'])) {
            list($ip, $port) = explode(':', base64_decode($_COOKIE['configuration']));
            if($ip === $params['ip'] && $port === $port) {
                $this->container->get('flash')->addMessage('error', 'Please make changes before saving');
                return $response->withHeader('location', '/')->withStatus(302);
            }
        }

        if(empty($params['ip']) || empty($params['port'])) {
            $this->container->get('flash')->addMessage('error', 'Please fill out all forms');
            return $response->withHeader('location', '/')->withStatus(302);
        }

        if(!filter_var($params['ip'], FILTER_VALIDATE_IP)) {
            $this->container->get('flash')->addMessage('error', 'The format ipv4 is not correct');
            return $response->withHeader('location', '/')->withStatus(302);
        }

        if(!filter_var($params['port'], FILTER_VALIDATE_INT)) {
            $this->container->get('flash')->addMessage('error', 'The port must be integer');
            return $response->withHeader('location', '/')->withStatus(302);
        }

        setcookie('configuration', base64_encode($params['ip'].':'.$params['port']));

        $this->container->get('flash')->addMessage('success', 'Your configuration is added with success');

        return $response->withHeader('location', '/')->withStatus(302);

    }
}