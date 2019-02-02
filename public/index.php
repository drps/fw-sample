<?php

use Framework\Http\Emitter;
use Framework\Http\Request;
use Framework\Http\Response;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = new Request();
$name = $request->getQueryParams()['name'] ?? 'ooops';
$response = new Response("Hello, {$name}!", 200);



$emitter = new Emitter();
$emitter->emit($response);
