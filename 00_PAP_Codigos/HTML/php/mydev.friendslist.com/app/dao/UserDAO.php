<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ .'/../models/User.php';

class UserDAO
{
    // IMPORTANT!: isto podia estar numa classe parent dao
    private $conn;
    public function __construct()
    {
        $this->conn = (new DataBase())->connect();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT  * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($row);

        if ($row) {
            $user = new User(
                $row['id'],
                $row['username']
            );

            return $row;
        } else {
            return null;
        }
    }

    public function createPending($username, $email)
    {
        $sql = "
            INSERT INTO users (username, email, password, is_admin, is_verified, verified_at, created_at, updated_at, deleted_at)
            VALUES (?, ?, '', 0, 0, NULL, NOW(), NOW(), NULL)
        ";
 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $email]);
 
        return (int)$this->conn->lastInsertId();
    }
}