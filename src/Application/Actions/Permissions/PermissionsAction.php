<?php
declare(strict_types=1);

namespace App\Application\Actions\Permissions;

use App\Application\Actions\Action;
use App\Domain\PermissionsRepository;
use Psr\Log\LoggerInterface;


abstract class PermissionsAction extends Action {
    protected $permissionsRepository;

    public function __construct(LoggerInterface $logger, PermissionsRepository $permissionsRepository) {
        parent::__construct($logger);
        $this->permissionsRepository = $permissionsRepository;
    }

    
}