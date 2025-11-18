<?php declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Domain\Entities\Vehicle;
use Domain\ValueObjects\Location;
use Domain\ValueObjects\Price;

class VehicleController
{
    public function __construct(
        protected readonly VehicleRepositoryInterface $vehicleRepository,
    )
    {}

    public function index(Request $request)
    {
        $vehicles = $this->vehicleRepository->index();

        return Response::json([
            'message' => 'Listagem realizada com sucesso',
            'vehicles' => $vehicles,
        ]);
    }
}
