<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Authentication implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $isLoggedIn = $session->get('isLoggedIn') === TRUE;
        
        // Get current URI path
        $path = $request->getUri()->getPath();
        $path = ltrim($path, '/'); // Remove leading slash
        
        // Define public routes (accessible without login)
        $publicRoutes = ['', 'login', 'register', 'doLogin', 'doRegister'];
        
        // Check if current route is public
        $isPublicRoute = false;
        foreach ($publicRoutes as $route) {
            if ($path === $route || strpos($path, $route . '/') === 0) {
                $isPublicRoute = true;
                break;
            }
        }
        
        // If NOT logged in and trying to access protected route
        if (!$isLoggedIn && !$isPublicRoute) {
            return redirect()->to(base_url('/'))->with('error', 'Please login to access this page.');
        }
        
        // If LOGGED IN and trying to access login/register pages
        if ($isLoggedIn && $isPublicRoute) {
            return redirect()->to(base_url('dashboard'));
        }
        
        // Otherwise, allow the request
        return;
    }

    /**
     * Allows After filters to inspect and modify the response
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}