<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Vehicles;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class GetAllVehiclesAction extends VehiclesAction
{
    protected function action(): Response
    {
        return $this->respondWithData($this->vehiclesRepository->getAllVehicles());
    }
}