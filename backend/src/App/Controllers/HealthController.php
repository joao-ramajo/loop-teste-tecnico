<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use Monolog\Logger;

class HealthController
{
    public function __construct(private Logger $logger)
    {
    }

    public function check(Request $request)
    {
        $this->logger->info("Health check executed");
        return Response::json(['status' => 'ok']);
    }
}
