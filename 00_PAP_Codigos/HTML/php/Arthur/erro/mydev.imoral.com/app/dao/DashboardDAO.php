<?php

require_once __DIR__ . '/../config/Database.php';

class DashboardDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function salesToday(): int {
        $sql = "SELECT COUNT(*) 
        FROM pedidos 
        WHERE DATE(dt_compra) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function customersToday(): int {
        $sql = "SELECT COUNT(DISTINCT c.id_utilizador) 
                FROM pedidos p 
                INNER JOIN carrinhos c ON p.id_carrinho = c.id 
                WHERE DATE(p.dt_compra) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function tshirtsSoldToday(): int {
        $sql = "SELECT COALESCE(SUM(cp.quantidade), 0)
                FROM carrinho_produtos cp
                INNER JOIN pedidos p ON cp.id_carrinho = p.id_carrinho
                INNER JOIN produtos pr ON cp.id_produto = pr.id
                INNER JOIN produtos_pai pp ON pr.id_produto_pai = pp.id
                WHERE pp.tipo = 'Camisola' AND DATE(p.dt_compra) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function pantsSoldToday(): int {
        $sql = "SELECT COALESCE(SUM(cp.quantidade), 0)
                FROM carrinho_produtos cp
                INNER JOIN pedidos p ON cp.id_carrinho = p.id_carrinho
                INNER JOIN produtos pr ON cp.id_produto = pr.id
                INNER JOIN produtos_pai pp ON pr.id_produto_pai = pp.id
                WHERE pp.tipo = 'Calças' AND DATE(p.dt_compra) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}