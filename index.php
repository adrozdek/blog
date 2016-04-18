<?php

use Agata\Services\Application;

require __DIR__ . '/vendor/autoload.php';

session_start();
$start = new Application();
$start->start();