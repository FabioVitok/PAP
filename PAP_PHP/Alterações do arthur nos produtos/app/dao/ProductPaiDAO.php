<?php

require_once __DIR__ . '/../models/ProductPai.php';
require_once __DIR__ . '/../config/Database.php';

class ProductPaiDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToProductPai(array $row): ProductPai {
        return new ProductPai(
            id:          (int)$row['id'],
            nome:        $row['nome'],
            tipo:        $row['tipo'],
            cor:         $row['cor'] ?? null,
            image:       $row['image'] ?? null,
            preco_venda: (float)$row['preco_venda']
        );
    }

    public function findById(int $id): ProductPai|false {
        $sql = "SELECT  
                id,
                nome,
                tipo,
                cor,
                image,
                preco_venda
            FROM produtos_pai 
            WHERE id = ? 
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return false;

        return $this->rowToProductPai($row);
    }

    public function getAllProductsPai() {
        $sql = "SELECT 
            id,
            nome,
            tipo,
            cor,
            image,
            preco_venda
            FROM produtos_pai";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $products = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $products[] = $this->rowToProductPai($row);
        }
        return $products;
    }

    public function countProducts(): int {
        $sql = "SELECT COUNT(*) FROM produtos_pai";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}