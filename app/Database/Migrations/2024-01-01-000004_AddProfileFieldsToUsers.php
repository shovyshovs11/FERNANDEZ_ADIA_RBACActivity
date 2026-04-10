<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProfileFieldsToUsers extends Migration
{
    public function up(): void
    {
        $fields = [
            'student_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'password',
            ],
            'course' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'student_id',
            ],
            'year_level' => [
                'type'       => 'TINYINT',
                'null'       => true,
                'after'      => 'course',
            ],
            'section' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'year_level',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'section',
            ],
            'address' => [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'phone',
            ],
            'profile_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'address',
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down(): void
    {
        $this->forge->dropColumn('users', [
            'student_id',
            'course',
            'year_level',
            'section',
            'phone',
            'address',
            'profile_image',
        ]);
    }
}