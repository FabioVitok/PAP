<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';

class UserDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToUser(array $row): User {
        return new User(
            id:            (int)$row['id'],
            username:      $row['username'],
            email:         $row['email'],
            image:         $row['image'] ?? null,
            telefone:      $row['telefone'] ?? null,
            password:      $row['password'],
            morada:        $row['morada'] ?? '',
            dt_nascimento: $row['dt_nascimento'] ?? '',
            dt_criacao:    $row['dt_criacao'] ?? '',
            pronomes:      $row['pronomes'] ?? null,
            is_admin:      (bool)$row['is_admin'],
            ultimo_login:  $row['ultimo_login'] ?? '',
            is_verified:   (bool)$row['is_verified'],
            verified_at:   $row['verified_at'] ?? null,
            created_at:    $row['created_at'],
            updated_at:    $row['updated_at'],
            deleted_at:    $row['deleted_at'] ?? null
        );
    }

    public function findUserById($userId){
        $sql = "
            SELECT 
                utilizadores.id,
                utilizadores.username,
                utilizadores.email,
                utilizadores.image,
                utilizadores.telefone,
                utilizadores.password,
                utilizadores.morada,
                utilizadores.dt_nascimento,
                utilizadores.dt_criacao,
                utilizadores.pronomes,
                utilizadores.is_admin,
                utilizadores.ultimo_login,
                utilizadores.is_verified,
                utilizadores.verified_at,
                utilizadores.created_at,
                utilizadores.updated_at,
                utilizadores.deleted_at
            FROM utilizadores 
            WHERE id = ?
            AND is_verified = 1
            AND verified_at IS NOT NULL
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if(!$row) {
            return false;
        }
    
        return $row;
    }

    public function findUserByIdDash($userId){
        $sql = "
            SELECT 
                utilizadores.id,
                utilizadores.username,
                utilizadores.email,
                utilizadores.image,
                utilizadores.telefone,
                utilizadores.password,
                utilizadores.morada,
                utilizadores.dt_nascimento,
                utilizadores.dt_criacao,
                utilizadores.pronomes,
                utilizadores.is_admin,
                utilizadores.ultimo_login,
                utilizadores.is_verified,
                utilizadores.verified_at,
                utilizadores.created_at,
                utilizadores.updated_at,
                utilizadores.deleted_at
            FROM utilizadores 
            WHERE id = ?
            AND is_verified = 1
            AND verified_at IS NOT NULL
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if(!$row) {
            return false;
        }
    
        return new User(
            (int)$row['id'],
            $row['username'],
            $row['email'],
            $row['image'],
            $row['telefone'],
            $row['password'],
            $row['morada'],
            $row['dt_nascimento'],
            $row['dt_criacao'],
            $row['pronomes'],
            (bool)$row['is_admin'],
            $row['ultimo_login'],
            (bool)$row['is_verified'],
            $row['verified_at'],
            $row['created_at'],
            $row['updated_at'],
            $row['deleted_at']
        );
    }

    public function findByEmail($email): User|false {
        $sql = "
            SELECT * 
            FROM utilizadores 
            WHERE email = :email
            AND is_verified = 1
            AND verified_at IS NOT NULL
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->rowToUser($row) : false;
    }

    public function updateUser($userId, $username, $email): int {
        $sql = "
            UPDATE utilizadores 
            SET username = ?, email = ?, updated_at = NOW()
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $email, $userId]);
        return $stmt->rowCount();
    }

    public function getUsersDao(): array {
        $sql = "
            SELECT 
                utilizadores.id,
                utilizadores.username,
                utilizadores.email,
                utilizadores.image,
                utilizadores.telefone,
                utilizadores.password,
                utilizadores.morada,
                utilizadores.dt_nascimento,
                utilizadores.dt_criacao,
                utilizadores.pronomes,
                utilizadores.is_admin,
                utilizadores.ultimo_login,
                utilizadores.is_verified,
                utilizadores.verified_at,
                utilizadores.created_at,
                utilizadores.updated_at,
                utilizadores.deleted_at
            FROM utilizadores 
            WHERE is_verified = 1 AND verified_at IS NOT NULL
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];

        foreach($rows as $row) {
            $users[] = $this->rowToUser($row);
        }
        
        return $users;
    }

    public function createPending($username, $email, ?string $image = null): int {
        $sql = "
            INSERT INTO utilizadores 
                (username, email, password, is_admin, image, morada, dt_nascimento, dt_criacao, pronomes, ultimo_login, is_verified, verified_at, created_at, updated_at, deleted_at)
            VALUES 
                (?, ?, '', 0, ?, '', NULL, NOW(), NULL, NULL, 0, NULL, NOW(), NOW(), NULL)
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $email, $image]);
        return (int)$this->conn->lastInsertId();
    }

    public function setPasswordAndVerify($userId, $passwordHash): void {
        $sql = "
            UPDATE utilizadores
            SET password = ?, 
                is_verified = 1, 
                verified_at = NOW(),
                updated_at = NOW()
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$passwordHash, $userId]);
    }

    public function arrayUsersDAO() {
        $sql = "
            SELECT
                utilizadores.id,
                utilizadores.username,
                utilizadores.email,
                utilizadores.image,
                utilizadores.telefone,
                utilizadores.password,
                utilizadores.morada,
                utilizadores.dt_nascimento,
                utilizadores.dt_criacao,
                utilizadores.pronomes,
                utilizadores.is_admin,
                utilizadores.ultimo_login,
                utilizadores.is_verified,
                utilizadores.verified_at,
                utilizadores.created_at,
                utilizadores.updated_at,
                utilizadores.deleted_at 
            FROM utilizadores;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function countUsers(){
        $sql = "
            SELECT COUNT(*) as num_users 
            FROM utilizadores;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function updateImage(int $userId, string $image): void {
        $sql = "
            UPDATE utilizadores 
            SET image = ?, updated_at = NOW() 
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$image, $userId]);
    }

    public function usersEstado(int $userId): string {
        $sql = "
            SELECT e.nome_estado
            FROM utilizadores u
            INNER JOIN estado_utilizadores eu ON u.id = eu.id_utilizador
            INNER JOIN estados e ON eu.id_estado = e.id
            WHERE u.id = ?
            ORDER BY eu.data_alteracao DESC, eu.id DESC
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        return (string)$stmt->fetchColumn();
    }

    public function setUserEstado(int $userId, int $estadoId): void {
        $sql = "
            INSERT INTO estado_utilizadores (id_utilizador, id_estado, data_alteracao)
            VALUES (?, ?, NOW())
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $estadoId]);
    }

    public function deleteUser(int $userId, int $estadoId): string {
        $this->setUserEstado($userId, $estadoId); // 7 = Conta Banida

        $sql = "
            UPDATE utilizadores 
            SET deleted_at = NOW() 
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);

        $sql2 = "
            SELECT deleted_at 
            FROM utilizadores 
            WHERE id = ?";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->execute([$userId]);

        return (string)$stmt2->fetchColumn();
    }

    public function unbanUser(int $userId, int $estadoId): string {
        $this->setUserEstado($userId, $estadoId); // 9 = Conta Ativa

        $sql = "
            UPDATE
            utilizadores
            SET deleted_at = NULL 
            WHERE id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        
        $sql2 = "
            SELECT deleted_at 
            FROM utilizadores 
            WHERE id = ?";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->execute([$userId]);

        return (string)$stmt2->fetchColumn();
    }
}

?>