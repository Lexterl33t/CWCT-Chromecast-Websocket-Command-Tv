<?php
$app->get('/', \App\Controllers\HomeCore::class.':index');
$app->post('/', \App\Controllers\HomeCore::class.':save_remote');