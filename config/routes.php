<?php

/** @var \Framework\Http\Application $app */

$app->get('/', \App\Http\Action\BlogAction::class, 'home');
$app->get('/blog/{id}', \App\Http\Action\BlogAction::class);
