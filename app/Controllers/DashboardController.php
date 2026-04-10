<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'user' => session()->get()
        ];
        return view('dashboard/index', $data);
    }
}