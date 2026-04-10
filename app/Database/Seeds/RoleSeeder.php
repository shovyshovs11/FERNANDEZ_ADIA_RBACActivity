<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'        => 'admin',
                'label'       => 'Administrator',
                'description' => 'Full system access',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'teacher',
                'label'       => 'Teacher',
                'description' => 'Can manage records and view students',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'student',
                'label'       => 'Student',
                'description' => 'Can view own profile and dashboard',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'coordinator',
                'label'       => 'Coordinator',
                'description' => 'Challenge role with extended permissions',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($data as $role) {
            $exists = $this->db->table('roles')
                               ->where('name', $role['name'])
                               ->countAllResults();

            if (! $exists) {
                $this->db->table('roles')->insert($role);
            }
        }
    }
}