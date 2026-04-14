<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BaseApiController extends BaseController
{
    protected array $apiUser = [];

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->apiUser = session('api_user') ?? [];
    }

    protected function ok($data = null, string $message = 'OK'): ResponseInterface
    {
        return $this->response->setStatusCode(200)->setJSON([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function created($data = null, string $message = 'Created'): ResponseInterface
    {
        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function notFound(string $message = 'Not found'): ResponseInterface
    {
        return $this->response->setStatusCode(404)->setJSON([
            'status' => 'error',
            'message' => $message,
        ]);
    }

    protected function badRequest(string $message = 'Bad request', $errors = null): ResponseInterface
    {
        return $this->response->setStatusCode(400)->setJSON([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ]);
    }

    protected function unauthorized(string $message = 'Unauthorized'): ResponseInterface
    {
        return $this->response->setStatusCode(401)->setJSON([
            'status' => 'error',
            'message' => $message,
        ]);
    }

    protected function forbidden(string $message = 'Forbidden'): ResponseInterface
    {
        return $this->response->setStatusCode(403)->setJSON([
            'status' => 'error',
            'message' => $message,
        ]);
    }
}