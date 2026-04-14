<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiTokenModel extends Model
{
    protected $table = 'api_tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'token', 'expires_at', 'created_at'];

    public function createToken(int $userId, string $token, string $expiresAt): int
    {
        return $this->insert([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => $expiresAt,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function deleteByToken(string $token): bool
    {
        return $this->where('token', $token)->delete();
    }
}