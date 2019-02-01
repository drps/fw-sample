<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$name = $_GET['name'] ?? 'sasa';

echo "Hello, {$name}!";