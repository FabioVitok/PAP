<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';

class UserDAO{

    private $conn;

    public function __construct() {
        // Conexão à base de dados
        $this->conn = (new Database())->connect();
    }

    public function findById($userId) {
        $sql = "
            SELECT * 
            FROM users 
            WHERE id = :id
            AND is_verified = 1
            AND verified_at IS NOT NULL
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $userId);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //var_dump($row);

        if($row) {
            $user = new User(
            $row['id'],
            $row['username'],
            $row['email'],
            $row['password'],
            $row['is_admin']
        );
        
        return $user;
        } else {
            return false;
        }
    }

    public function findByEmail($email) {
        $sql = "
            SELECT * 
            FROM users 
            WHERE email = :email
            AND is_verified = 1
            AND verified_at IS NOT NULL
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':email', $email);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //var_dump($row);

        if($row) {
            $user = new User(
            $row['id'],
            $row['username'],
            $row['email'],
            $row['password'],
            $row['is_admin']
        );
        
        return $user;
        } else {
            return false;
        }
    }

    public function createPending($username, $email ) {
        $sql = "
        INSERT INTO users (username, email, password, is_admin, is_verified, verified_at, created_at, updated_at, deleted_at)
        VALUES (?, ?, '', 0, 0, NULL, NOW(), NOW(), NULL)
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $email]);
        
        return (int)$this->conn->lastInsertId();
    }

    public function setPasswordAndVerify($userId, $passwordHash) {
        $sql = "
            UPDATE users
            SET password = ?, 
                is_verified = 1, 
                verified_at = NOW(),
                updated_at = NOW()
            WHERE id = ?
        ";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$passwordHash, $userId]);
    }

}