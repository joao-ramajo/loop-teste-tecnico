<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Response;

class VehicleController
{
    public function index()
    {
        return Response::json(['message' => 'Listando carros']);
    }
}