<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;

class RoleController extends BaseController
{
    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        helper(['form', 'url']); // fixes: Call to undefined function set_value()
    }

    public function index()
    {
        $roles = $this->roleModel->findAll();

        $db      = \Config\Database::connect();
        $builder = $db->table('users')
                      ->select('role_id, COUNT(*) as count')
                      ->groupBy('role_id')
                      ->get()
                      ->getResultArray();

        $counts = array_column($builder, 'count', 'role_id');

        return view('admin/roles/index', ['roles' => $roles, 'counts' => $counts]);
    }

    public function create()
    {
        return view('admin/roles/create');
    }

    public function store()
    {
        $rules = [
            'name'  => 'required|alpha_dash|is_unique[roles.name]',
            'label' => 'required',
        ];

        if (! $this->validate($rules)) {
            return view('admin/roles/create', ['validation' => $this->validator]);
        }

        $this->roleModel->insert([
            'name'        => strtolower($this->request->getPost('name')),
            'label'       => $this->request->getPost('label'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('admin/roles')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = $this->roleModel->find($id);
        if (! $role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/roles/edit', ['role' => $role]);
    }

    public function update($id)
    {
        $role = $this->roleModel->find($id);
        if (! $role) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $isCore = in_array($role['name'], ['admin', 'teacher', 'student']);

        $rules = ['label' => 'required'];
        if (! $isCore) {
            $rules['name'] = "required|alpha_dash|is_unique[roles.name,id,{$id}]";
        }

        if (! $this->validate($rules)) {
            return view('admin/roles/edit', ['role' => $role, 'validation' => $this->validator]);
        }

        $data = [
            'label'       => $this->request->getPost('label'),
            'description' => $this->request->getPost('description'),
        ];

        if (! $isCore) {
            $data['name'] = strtolower($this->request->getPost('name'));
        }

        $this->roleModel->update($id, $data);

        return redirect()->to('admin/roles')->with('success', 'Role updated successfully.');
    }

    public function delete($id)
    {
        $role = $this->roleModel->find($id);

        // Protect all core roles from deletion
        if ($role && ! in_array($role['name'], ['admin', 'teacher', 'student'])) {
            $this->roleModel->delete($id);
            return redirect()->to('admin/roles')->with('success', 'Role deleted.');
        }

        return redirect()->to('admin/roles')->with('error', 'Cannot delete core roles.');
    }
}