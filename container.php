<?php

$container->set('view', function(\Psr\Container\ContainerInterface $container) {
    $templates = new League\Plates\Engine(dirname(__FILE__).'/views');
    $templates->addData(['container' => $container]);

    return $templates;
});

$container->set('flash', function() {
    return new \Slim\Flash\Messages();
});