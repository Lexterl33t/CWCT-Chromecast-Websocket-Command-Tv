<?php

$container->set('view', function() {
    $templates = new League\Plates\Engine(dirname(__FILE__).'/views');
    return $templates;
});