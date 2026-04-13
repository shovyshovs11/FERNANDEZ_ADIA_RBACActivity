<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        $sessionUser = session('user');

        $data['user'] = [
            'name'    => $sessionUser['name']  ?? '',
            'email'   => $sessionUser['email'] ?? '',
            'user_id' => $sessionUser['id']    ?? '',
            'role'    => $sessionUser['role']  ?? '',
        ];

        return view('dashboard/index', $data);
    }
}