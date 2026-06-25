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

    public function createProduct(int $id_produto_pai, string $tamanho, float $peso, float $preco_custo, int $stock): int {
        $sql = "
            INSERT INTO produtos (id_produto_pai, tamanho, peso, preco_custo, stock)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_produto_pai, $tamanho, $peso, $preco_custo, $stock]);

        return (int)$this->conn->lastInsertId();
    }

    public function getAllProductsComStats(): array {
        $sql = "
            SELECT 
                p.id, 
                p.id_produto_pai, 
                p.tamanho, 
                p.peso, 
                p.preco_custo, 
                p.stock,
                pp.nome AS nome, 
                pp.tipo AS tipo, 
                pp.cor AS cor, 
                pp.image AS image, 
                pp.preco_venda AS preco_venda,
                COALESCE(vendas.total_vendido, 0) AS sales,
                COALESCE(vendas.total_vendido * pp.preco_venda, 0) AS revenue
            FROM produtos p
            INNER JOIN produtos_pai pp ON p.id_produto_pai = pp.id
            LEFT JOIN (
                SELECT 
                    pp2.id_produto, 
                    SUM(pp2.quantidade) AS total_vendido
                FROM pedido_produtos pp2
                INNER JOIN pedidos pe ON pp2.id_pedido = pe.id
                GROUP BY pp2.id_produto
            ) vendas ON vendas.id_produto = p.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProduct(int $id): bool {
        $sql = "
            DELETE 
            FROM produtos 
            WHERE id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}