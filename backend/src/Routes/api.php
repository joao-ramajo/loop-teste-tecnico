<?php declare(strict_types=1);

use App\Controllers\AppointmentsController;
use App\Controllers\HealthController;
use App\Controllers\VehicleController;

/** @var \FastRoute\RouteCollector $router */
$router->addRoute('GET', '/api/v1/health', [HealthController::class, 'check']);

// Vehicles
$router->addRoute('GET', '/api/v1/vehicles', [VehicleController::class, 'index']);
$router->addRoute('GET', '/api/v1/vehicles/{vehicle_id}/slots', [VehicleController::class, 'dates']);

// Appointments
$router->addRoute('POST', '/api/v1/appointments', [AppointmentsController::class, 'store']);
