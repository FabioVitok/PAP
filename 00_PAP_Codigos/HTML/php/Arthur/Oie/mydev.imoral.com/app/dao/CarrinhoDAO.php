<?php

require_once __DIR__ . '/../models/Carrinho.php';
require_once __DIR__ . '/../config/Database.php';

class CarrinhoDAO{

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToCarrinho(array $row): Carrinho {
        return new Carrinho(
            id:            (int)$row['id'],
            id_utilizador: $row['id_utilizador'],
            custo_total:    $row['custo_total']
        );
    }

    public function findCarrinhoById($carrinhoId) {
        $sql = "
            SELECT 
                carrinhos.id,
                carrinhos.id_utilizador,
                carrinhos.custo_total
            FROM carrinhos
            WHERE carrinhos.id = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $carrinhoId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return false;
        }

        return $this->rowToCarrinho($row);
    }

    public function findCarrinhoByUserId($userId) {
        $sql = "
            SELECT 
                carrinhos.id,
                carrinhos.id_utilizador,
                carrinhos.custo_total
            FROM carrinhos
            WHERE carrinhos.id_utilizador = ?
            LIMIT 1;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->rowToCarrinho($row) : false;
    }

    public function createCarrinho($userId): int {
        $sql = "
            INSERT INTO carrinhos (id_utilizador, custo_total) 
            VALUES (?, 0.00)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        
        return $this->conn->lastInsertId();
    }
}