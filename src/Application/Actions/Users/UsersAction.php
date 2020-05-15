<?php
declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Log\LoggerInterface;

abstract class UsersAction extends Action
{
    protected $usersRepository;

    public function __construct(LoggerInterface $logger, UsersRepository $usersRepository) {
        parent::__construct($logger);
        $this->usersRepository = $usersRepository;
    }
}