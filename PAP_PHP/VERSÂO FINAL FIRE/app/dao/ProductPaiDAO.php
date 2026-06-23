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

    public function findProductPaiById(int $id): ProductPai|false {
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

    public function getAllProductsPai(): array {
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

    public function getAllProductsPaiComStats(): array {
        $sql = "
            SELECT 
                pp.id,
                pp.nome,
                pp.tipo,
                pp.cor,
                pp.image,
                pp.preco_venda,
                COALESCE(SUM(p.stock), 0) AS stock_total,
                COALESCE(SUM(vendas.total_vendido), 0) AS sales_total,
                COALESCE(SUM(vendas.total_vendido * pp.preco_venda), 0) AS revenue_total
            FROM produtos_pai pp
            LEFT JOIN produtos p ON p.id_produto_pai = pp.id
            LEFT JOIN (
                SELECT pp2.id_produto, SUM(pp2.quantidade) AS total_vendido
                FROM pedido_produtos pp2
                INNER JOIN pedidos pe ON pp2.id_pedido = pe.id
                GROUP BY pp2.id_produto
            ) vendas ON vendas.id_produto = p.id
            GROUP BY pp.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countProducts(): int {
        $sql = "SELECT COUNT(*) FROM produtos_pai";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function createProductPai(string $nome, string $tipo, ?string $cor, ?string $image, float $preco_venda): int {
        $sql = "
            INSERT INTO produtos_pai (nome, tipo, cor, image, preco_venda)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nome, $tipo, $cor, $image, $preco_venda]);

        return (int)$this->conn->lastInsertId();
    }

    public function updateProductPai(int $id, string $nome, string $tipo, ?string $cor, ?string $image, float $preco_venda): bool {
        $sql = "UPDATE produtos_pai 
                SET nome = ?, tipo = ?, cor = ?, image = ?, preco_venda = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nome, $tipo, $cor, $image, $preco_venda, $id]);
    }
}