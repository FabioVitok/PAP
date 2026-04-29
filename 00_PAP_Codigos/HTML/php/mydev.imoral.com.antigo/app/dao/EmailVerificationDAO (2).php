<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';

class EmailVerificationDAO
{
    // IMPORTANT!: isto podia estar numa classe parent dao
    private $conn;
    public function __construct()
    {
        $this->conn = (new DataBase())->connect();
    }

    public function createForUser($userId, $ttlSeconds = 300)
    {
        // 1) IMPORTANTE!: gerar token único e seguro pode ser discutido posteriormente na PAP
        $token = bin2hex(random_bytes(32) . round(microtime(true) * 1000));

        // 2) sha256 é uma função de hash unidirecional de encriptação.
        $tokenHash = hash('sha256', $token);

        $sql = "
            INSERT INTO email_verifications (user_id, token_hash, expires_at, used_at, created_at)
            VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND), NULL, NOW())
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $tokenHash, $ttlSeconds]);

        return $token;
    }
}