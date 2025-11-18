<?php declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\SlotService;
use DI\NotFoundException;
use Domain\Contracts\Repositories\SlotRepositoryInterface;
use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Domain\Entities\Vehicle;
use Domain\ValueObjects\Id;
use Domain\ValueObjects\Location;
use Domain\ValueObjects\Price;
use Dotenv\Exception\ValidationException;

class VehicleController
{
    public function __construct(
        protected readonly VehicleRepositoryInterface $vehicleRepository,
        protected readonly SlotService $slotService,
    ) {}

    public function index()
    {
        $vehicles = $this->vehicleRepository->index();

        return Response::json([
            'message' => 'Listagem realizada com sucesso',
            'vehicles' => $vehicles,
        ]);
    }

    public function dates(Request $request, int $vehicle_id)
    {
        try {
            $dates = $this->slotService->getAvailableDates($vehicle_id);

            return Response::json([
                'message' => 'Datas disponiveis',
                'data' => $dates,
            ]);
        } catch (NotFoundException $e) {
            return Response::error($e->getMessage(), 404);
        } catch(ValidationException $e){
            return Response::error($e->getMessage(), 404);
        }
    }
}
