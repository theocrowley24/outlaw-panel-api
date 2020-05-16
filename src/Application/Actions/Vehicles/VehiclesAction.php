<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Vehicles;

use App\Application\Actions\Action;
use App\Domain\VehiclesRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Log\LoggerInterface;

abstract class VehiclesAction extends Action
{
    protected $vehiclesRepository;

    public function __construct(LoggerInterface $logger, VehiclesRepository $vehiclesRepository)
    {
        parent::__construct($logger);
        $this->vehiclesRepository = $vehiclesRepository;
    }
}