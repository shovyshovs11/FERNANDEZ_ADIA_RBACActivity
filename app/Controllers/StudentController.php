<?php

namespace App\Controllers;

class StudentController extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login first.');
        }

        $data['user'] = [
            'name'    => session()->get('name') ?? session('user')['name'],
            'email'   => session()->get('email') ?? session('user')['email'],
            'user_id' => session()->get('user_id') ?? session('user')['id'],
            'role'    => session('user')['role'] ?? 'student',
        ];

        return view('dashboard/index', $data);
    }
}
