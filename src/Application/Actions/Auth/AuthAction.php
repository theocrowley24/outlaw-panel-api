<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Domain\Auth\AuthRepository;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class AuthAction extends Action {
    private $authRepository;

    public function __construct(LoggerInterface $logger, AuthRepository $authRepository) {
        parent::__construct($logger);
        $this->authRepository = $authRepository;
    }

    public function action(): Response {
        $parsedBody = $this->request->getParsedBody();
        $username = $parsedBody['username'];
        $password = $parsedBody['password'];

        if (!$username || !$password) {
            $this->respondWithData("Failed");
        }

        return $this->respondWithData($this->authRepository->login($username, $password));
    }
}