<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Symfony\Kernel;
use Spatie\Ignition\Ignition;
use Symfony\Component\HttpFoundation\Request;

require_once '../vendor/autoload.php';

Ignition::make()->register();

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
