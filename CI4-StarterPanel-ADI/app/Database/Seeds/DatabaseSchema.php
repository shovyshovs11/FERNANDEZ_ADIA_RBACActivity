<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSchema extends Seeder
{
    public function run()
    {
        // Users table
        $this->db->query("
            CREATE TABLE IF NOT EXISTS users (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // Records table
        $this->db->query("
            CREATE TABLE IF NOT EXISTS records (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                category VARCHAR(100),
                status VARCHAR(50) DEFAULT 'active',
                price DECIMAL(10,2),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");
    }
}