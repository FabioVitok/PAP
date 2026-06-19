<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../config/Database.php';

class ProductDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToProduct(array $row): Product {
        return new Product(
            id:             (int)$row['id'],
            id_produto_pai: (int)$row['id_produto_pai'],
            tamanho:        $row['tamanho'],
            peso:           (float)$row['peso'],
            preco_custo:    (float)$row['preco_custo'],
            stock:          (int)$row['stock']
        );
    }

    public function findById(int $id): Product|false {
        $sql = "SELECT 
                    id,
                    id_produto_pai,
                    tamanho,
                    peso,
                    preco_custo,
                    stock
                FROM produtos WHERE id = ? LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return false;

        return $this->rowToProduct($row);
    }

    public function findByPaiId(int $id_produto_pai): array {
        $sql = "SELECT 
                    id,
                    id_produto_pai,
                    tamanho,
                    peso,
                    preco_custo,
                    stock
                FROM produtos WHERE id_produto_pai = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id_produto_pai, PDO::PARAM_INT);
        $stmt->execute();

        $variants = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $variants[] = $this->rowToProduct($row);
        }
        return $variants;
    }

    public function updateProduct(int $id, string $tamanho, float $peso, float $preco_custo, int $stock): int {
        $sql = "
            UPDATE produtos 
            SET tamanho = ?, peso = ?, preco_custo = ?, stock = ?
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tamanho, $peso, $preco_custo, $stock, $id]);
        return $stmt->rowCount();
    }

    public function productsRevenue(int $productId): int {
        $sql = "
            SELECT SUM(pp.preco_venda * cp.quantidade) AS receita
            FROM carrinho_produtos AS cp
            INNER JOIN produtos AS p ON cp.id_produto = p.id
            INNER JOIN produtos_pai AS pp ON p.id_produto_pai = pp.id
            INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
            WHERE p.id = ?
            GROUP BY p.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productId]);
        return (int)$stmt->fetchColumn();
    }

    public function productsSales(int $productId): int {
        $sql = "
            SELECT SUM(cp.quantidade) AS total_vendido
            FROM carrinho_produtos AS cp
            INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
            WHERE cp.id_produto = ?
            GROUP BY cp.id_produto
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productId]);
        return (int)$stmt->fetchColumn();
    }
}