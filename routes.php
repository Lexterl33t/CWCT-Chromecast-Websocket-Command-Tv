<?php
$app->get('/', \App\Controllers\HomeCore::class.':index');
$app->post('/save_remote', \App\Controllers\HomeCore::class.':save_remote');
$app->post('/play_chromecast', \App\Controllers\HomeCore::class.':play');
$app->post('/stop_chromecast', \App\Controllers\HomeCore::class.':stop');
$app->post('/restart_chromecast', \App\Controllers\HomeCore::class.':restart');
$app->post('/set_volume', \App\Controllers\HomeCore::class.':volume');
$app->post('/pause_chromecast', \App\Controllers\HomeCore::class.':pause');
$app->post('/mute_chromecast', \App\Controllers\HomeCore::class.':mute');
$app->post('/unmute_chromecast', \App\Controllers\HomeCore::class.':unmute');