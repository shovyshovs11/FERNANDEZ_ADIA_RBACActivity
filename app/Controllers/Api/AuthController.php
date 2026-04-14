<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use App\Models\ApiTokenModel;

class AuthController extends BaseApiController
{
    private const TOKEN_TTL = 86400; // 24 hours

    /**
     * POST /api/v1/auth/token
     * Issue token - ADAPTED for your UserModel
     */
    public function issueToken()
    {
        $email = $this->request->getJsonVar('email') ?? $this->request->getPost('email');
        $password = $this->request->getJsonVar('password') ?? $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return $this->badRequest('Email and password are required.');
        }

        $userModel = new UserModel();

        // ADAPTED: Use standard query since your UserModel may not have findByEmail
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['status' => 'error', 'message' => 'Invalid credentials.']);
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + self::TOKEN_TTL);

        (new ApiTokenModel())->createToken($user['id'], $token, $expiresAt);

        return $this->created([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt,
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ],
        ], 'Token issued successfully.');
    }

    /**
     * DELETE /api/v1/auth/token
     * Revoke token
     */
    public function revokeToken()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = trim(substr($authHeader, 7));

        (new ApiTokenModel())->deleteByToken($token);

        return $this->ok(null, 'Token revoked successfully.');
    }
}