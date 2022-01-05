<?php

namespace App\Controllers;

use App\Cast\Chromecast;
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

        if (isset($_COOKIE['configuration'])) {
            list($ip, $port) = explode(':', base64_decode($_COOKIE['configuration']));
            if ($ip === $params['ip'] && $port === $port) {
                $this->container->get('flash')->addMessage('error', 'Please make changes before saving');
                return $response->withHeader('location', '/')->withStatus(302);
            }
        }

        if (empty($params['ip']) || empty($params['port'])) {
            $this->container->get('flash')->addMessage('error', 'Please fill out all forms');
            return $response->withHeader('location', '/')->withStatus(302);
        }

        if (!filter_var($params['ip'], FILTER_VALIDATE_IP)) {
            $this->container->get('flash')->addMessage('error', 'The format ipv4 is not correct');
            return $response->withHeader('location', '/')->withStatus(302);
        }

        if (!filter_var($params['port'], FILTER_VALIDATE_INT)) {
            $this->container->get('flash')->addMessage('error', 'The port must be integer');
            return $response->withHeader('location', '/')->withStatus(302);
        }

        setcookie('configuration', base64_encode($params['ip'] . ':' . $params['port']));

        $this->container->get('flash')->addMessage('success', 'Your configuration is added with success');

        return $response->withHeader('location', '/')->withStatus(302);

    }

    public function play(Request $request, Response $response)
    {
        $params = filter_var_array($request->getParsedBody());

        if(!isset($_COOKIE['configuration'])) {
            echo json_encode(['error' => 'Please configure a remote connection']);
            return $response;
        }

        if (empty($params['url'])) {
            echo json_encode(['error' => 'Please fill out url form']);
            return $response;
        }

        if(!filter_var($params['url'], FILTER_VALIDATE_URL))  {
            echo json_encode(['error' => 'The format of url is incorrect']);
            return $response;
        }

        $ip = htmlspecialchars(explode(':',base64_decode($_COOKIE['configuration']))[0]);

        $port = htmlspecialchars(explode(':',base64_decode($_COOKIE['configuration']))[1]);


        $cc = new Chromecast($ip, $port);


        $cc->DMP->play($params['url'],"BUFFERED","video/mp4",true,0);
        $cc->DMP->SetVolume($params['volume']);
        $_SESSION['player'] = serialize($cc);
        echo json_encode(['success' => 'Video started']);
        return $response;
    }

    public function stop(Request $request, Response $response)
    {
        if(!isset($_COOKIE['configuration'])) {
            echo json_encode(['error' => 'Please configure a remote connection']);
            return $response;
        }

        if(!isset($_SESSION['player'])) {
            echo json_encode(['error' => 'Remember to start a video before stopping it']);
            return $response;
        }

        $obj = unserialize($_SESSION['player']);
        $obj->DMP->Stop();

        session_destroy();

        echo json_encode(["success" => "Video stopped with success"]);
        return $response;
    }

    public function restart(Request $request, Response $response)
    {
        if(!isset($_COOKIE['configuration'])) {
            echo json_encode(['error' => 'Please configure a remote connection']);
            return $response;
        }


        if(!isset($_SESSION['player'])) {
            echo json_encode(['error' => 'Remember to start a video before stopping it']);
            return $response;
        }

        $obj = unserialize($_SESSION['player']);
        $obj->DMP->restart();

        echo json_encode(['success' => 'Video restarted']);
        return $response;
    }

    public function pause(Request $request, Response $response)
    {
        if(!isset($_COOKIE['configuration'])) {
            echo json_encode(['error' => 'Please configure a remote connection']);
            return $response;
        }


        if(!isset($_SESSION['player'])) {
            echo json_encode(['error' => 'Remember to start a video before stopping it']);
            return $response;
        }

        $obj = unserialize($_SESSION['player']);
        $obj->DMP->pause();

        echo json_encode(['success' => 'Video in pause']);
        return $response;
    }

    public function mute(Request $request, Response $response)
    {
        if(!isset($_COOKIE['configuration'])) {
            echo json_encode(['error' => 'Please configure a remote connection']);
            return $response;
        }


        if(!isset($_SESSION['player'])) {
            echo json_encode(['error' => 'Remember to start a video before stopping it']);
            return $response;
        }

        $obj = unserialize($_SESSION['player']);
        $obj->DMP->Mute();

        echo json_encode(['success' => 'Video muted']);
        return $response;
    }

    public function unmute(Request $request, Response $response)
    {
        if(!isset($_COOKIE['configuration'])) {
            echo json_encode(['error' => 'Please configure a remote connection']);
            return $response;
        }


        if(!isset($_SESSION['player'])) {
            echo json_encode(['error' => 'Remember to start a video before stopping it']);
            return $response;
        }

        $obj = unserialize($_SESSION['player']);
        $obj->DMP->UnMute();

        echo json_encode(['success' => 'Video unmuted']);
        return $response;
    }

    public function volume(Request $request, Response $response)
    {
        $params = filter_var_array($request->getParsedBody());
        if(!isset($_COOKIE['configuration'])) {
            echo json_encode(['error' => 'Please configure a remote connection']);
            return $response;
        }


        if(!isset($_SESSION['player'])) {
            echo json_encode(['error' => 'Remember to start a video before stopping it']);
            return $response;
        }

        $obj = unserialize($_SESSION['player']);
        $obj->DMP->SetVolume($params['volume']);

        echo json_encode(['success' => 'Volume up']);
        return $response;
    }
}