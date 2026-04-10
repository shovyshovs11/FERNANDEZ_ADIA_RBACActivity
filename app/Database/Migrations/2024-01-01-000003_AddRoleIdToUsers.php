<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleIdToUsers extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('users', [
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
                'after'   => 'updated_at',
            ],
        ]);

        $this->forge->addForeignKey('role_id', 'roles', 'id', 'SET NULL', 'CASCADE', 'fk_users_role_id');
    }

    public function down(): void
    {
        $this->forge->dropForeignKey('users', 'fk_users_role_id');
        $this->forge->dropColumn('users', 'deleted_at');
    }
}