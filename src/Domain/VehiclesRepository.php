<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Domain;


class VehiclesRepository extends Repository
{
    public function getAllVehicles(): array
    {
        $statement = $this->database
            ->select(array("*"))
            ->from("`takistan-vehicles`");

        $result = $statement->execute()->fetchAll();

        return $result;
    }
}