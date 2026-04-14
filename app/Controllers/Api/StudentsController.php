<?php

namespace App\Controllers\Api;

use App\Models\UserModel;

class StudentsController extends BaseApiController
{
    protected $userModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->userModel = new UserModel();
    }

    /**
     * GET /api/v1/students
     * Get all students - ADAPTED for your role structure
     */
    public function index()
    {
        // ADAPTED: Check if user has teacher/admin/coordinator access
        if (!$this->hasTeacherAccess()) {
            return $this->forbidden('Only teachers, admins, and coordinators can list students.');
        }

        // ADAPTED: Fetch students (role_id = 1 for student, or check role name)
        // Adjust this based on your actual roles table
        $students = $this->userModel
            ->select('users.id, users.fullname, users.email, users.photo, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('roles.name', 'student')
            ->findAll();

        // Remove sensitive data
        $students = array_map([$this, 'sanitize'], $students);

        return $this->ok($students);
    }

    /**
     * GET /api/v1/students/(:num)
     * Get single student by ID
     */
    public function show(int $id)
    {
        if (!$this->hasTeacherAccess()) {
            return $this->forbidden('Only teachers, admins, and coordinators can view student details.');
        }

        // ADAPTED: Query to get single student with role info
        $student = $this->userModel
            ->select('users.id, users.fullname, users.email, users.photo, users.bio, users.birthdate, users.contact, users.address, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $id)
            ->where('roles.name', 'student')
            ->first();

        if (!$student) {
            return $this->notFound("Student #{$id} not found.");
        }

        return $this->ok($this->sanitize($student));
    }

    /**
     * Check if user has teacher-level access
     * ADAPTED: Includes coordinator role from your project
     */
    private function hasTeacherAccess(): bool
    {
        if (!$this->apiUser || !isset($this->apiUser['role_name'])) {
            return false;
        }

        $allowedRoles = ['teacher', 'admin', 'coordinator'];
        return in_array($this->apiUser['role_name'], $allowedRoles, true);
    }

    /**
     * Remove sensitive fields from output
     */
    private function sanitize(array $row): array
    {
        unset($row['password'], $row['deleted_at']);
        return $row;
    }
}