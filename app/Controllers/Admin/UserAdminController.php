<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class UserAdminController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $roleModel = new RoleModel();

        $users = $userModel->select('users.*, roles.label as role_label')
                           ->join('roles', 'users.role_id = roles.id', 'left')
                           ->findAll();
        
        $roles = $roleModel->findAll();

        return view('admin/users/index', ['users' => $users, 'roles' => $roles]);
    }

    public function assignRole($id)
    {
        $userModel = new UserModel();
        
        if ($id == session('user')['id']) {
            return redirect()->to('admin/users')->with('error', 'Cannot change your own role.');
        }

        $roleId = $this->request->getPost('role_id');
        $userModel->update($id, ['role_id' => $roleId ?: null]);

        return redirect()->to('admin/users')->with('success', 'Role assigned. User must re-login for changes.');
    }
}