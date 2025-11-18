<?php declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use Domain\Entities\Vehicle;

class VehicleController
{
    public function index(Request $request)
    {
        $vehicle = new Vehicle(1, 'http://imagem.png', 'Volkswagen', 'Gol', '1.0', 12345, 'Mogi das Cruzes');

        $payload = [
            'message' => 'Listagem realizada com sucesso',
            'vehicles' => [
                $vehicle
            ]
        ];

        return Response::json($payload);
    }
}
