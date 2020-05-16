<?php
/**
 * Copyright (c) 2020, Theo Crowley. All rights reserved.
 */

declare(strict_types=1);

namespace App\Application\Actions\Players;

use App\Application\Actions\Action;
use App\Domain\PlayersRepository;
use Psr\Log\LoggerInterface;


abstract class PlayersAction extends Action
{
    protected $playersRepository;

    public function __construct(LoggerInterface $logger, PlayersRepository $playersRepository)
    {
        parent::__construct($logger);
        $this->playersRepository = $playersRepository;
    }


}