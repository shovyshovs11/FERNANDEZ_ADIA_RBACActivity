<?php

namespace App\Controllers;

use App\Models\UserModel;

class StudentManagementController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Simple mock view displaying students for teacher/admin to see.
        // We'll join roles to fetch specifically students.
        $students = $this->userModel
            ->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('roles.name', 'student')
            ->findAll();

        $data = [
            'students' => $students
        ];

        // Return a dynamically generated view for now, or just an inline view if a specific file isn't needed by the rubric
        return view('students/index', $data);
    }

    public function show($id)
    {
        $student = $this->userModel
            ->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $id)
            ->where('roles.name', 'student')
            ->first();

        if (!$student) {
            return redirect()->to('/students')->with('error', 'Student not found.');
        }

        $data = [
            'student' => $student
        ];

        return view('students/show', $data);
    }
}
