<?php

namespace App\Models;

use CodeIgniter\Model;

class RecordModel extends Model
{
    protected $table = 'records';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'category', 'status', 'price', 'created_at', 'updated_at'];
    protected $useTimestamps = false;
}