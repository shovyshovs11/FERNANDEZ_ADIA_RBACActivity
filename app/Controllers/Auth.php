<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    // Show login form
    public function login()
    {
        return view('auth/login');
    }

    // Process login
    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return view('auth/login', [
                'validation' => $this->validator
            ]);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel
            ->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('email', $email)
            ->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }

        // Set session data
        $sessionData = [
            'user' => [
                'id'       => $user['id'],
                'name'     => $user['name'],
                'email'    => $user['email'],
                'role'     => $user['role_name'] ?? 'student', // fallback if null
            ],
            // Keep old keys for backward compatibility with anything not updated
            'user_id'    => $user['id'],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);
        session()->set('role', $user['role_name'] ?? 'student'); // For easy access if needed

        $role = $user['role_name'] ?? 'student';

        // Role-based redirects
        return match($role) {
            'admin'   => redirect()->to('/dashboard')->with('success', 'Welcome back, ' . $user['name'] . '!'),
            'teacher' => redirect()->to('/dashboard')->with('success', 'Welcome back, ' . $user['name'] . '!'),
            'student' => redirect()->to('/student/dashboard')->with('success', 'Welcome back, ' . $user['name'] . '!'),
            default   => redirect()->to('/login')->with('error', 'Role not recognized.'),
        };
    }

    // Show register form
    public function register()
    {
        return view('auth/register');
    }

    // Process registration
    public function attemptRegister()
    {
        $rules = [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', [
                'validation' => $this->validator,
                'oldInput'   => $this->request->getPost()
            ]);
        }

    $data = [
        'name'       => $this->request->getPost('name'),
        'email'      => $this->request->getPost('email'),
        'password'   => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ];

        $this->userModel->insert($data);

        return redirect()->to('login')->with('success', 'Registration successful! Please login.');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login')->with('success', 'You have been logged out.');
    }

    // Show unauthorized page
    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}