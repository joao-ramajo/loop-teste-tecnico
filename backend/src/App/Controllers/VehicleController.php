<?php declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\SlotService;
use Domain\Contracts\Repositories\VehicleRepositoryInterface;
use Domain\Exceptions\ModelNotFoundException;
use Domain\Exceptions\NoAvailableDatesException;
use Monolog\Logger;
use Exception;

class VehicleController
{
    public function __construct(
        protected readonly VehicleRepositoryInterface $vehicleRepository,
        protected readonly SlotService $slotService,
        protected readonly Logger $log,
    ) {}

    public function index()
    {
        try {
            $vehicles = $this->vehicleRepository->index();

            return Response::json([
                'message' => 'Listagem realizada com sucesso',
                'vehicles' => $vehicles,
            ]);
        } catch (Exception $e) {
            $this->log->error('Erro ao listar veículos', [
                'message' => $e->getMessage(),
                'exception' => $e
            ]);
            return Response::error('erro interno do servidor.', 500);
        }
    }

    public function dates(Request $request, int $vehicle_id)
    {
        try {
            $dates = $this->slotService->getAvailableDates($vehicle_id);

            return Response::json([
                'message' => 'Datas disponiveis',
                'data' => $dates,
            ]);
        } catch (ModelNotFoundException $e) {
            return Response::error($e->getMessage(), 404);
        } catch (NoAvailableDatesException $e) {
            return Response::error($e->getMessage(), 422);
        } catch (Exception $e) {
            $this->log->error('Erro ao listar datas disponíveis', [
                'message' => $e->getMessage(),
                'exception' => $e
            ]);
            return Response::error('erro interno do servidor.', 500);
        }
    }
}
