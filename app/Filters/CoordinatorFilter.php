<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CoordinatorFilter implements FilterInterface
{
    protected array $allowedRoles = ['coordinator', 'admin'];

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!in_array(session('user')['role'], $this->allowedRoles, true)) {
            return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}