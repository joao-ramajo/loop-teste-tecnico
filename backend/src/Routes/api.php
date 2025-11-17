<?php

use App\Controllers\HealthController;
use App\Controllers\VehicleController;

/** @var \FastRoute\RouteCollector $router */

$router->addRoute('GET', '/api/v1/health', [HealthController::class, 'check']);

// Vehicles
$router->addRoute('GET', '/api/v1/vehicles', [VehicleController::class, 'index']);