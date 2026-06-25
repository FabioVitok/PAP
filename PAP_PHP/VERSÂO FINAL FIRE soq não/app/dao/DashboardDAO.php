<?php

require_once __DIR__ . '/../config/Database.php';

class DashboardDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function salesToday(): int {
        $sql = "SELECT COUNT(*) FROM pedidos WHERE DATE(dt_compra) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    
    public function salesYesterday(): int {
        $sql = "SELECT COUNT(*) FROM pedidos WHERE DATE(dt_compra) = CURDATE() - INTERVAL 1 DAY";
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
    
    public function customersYesterday(): int {
        $sql = "SELECT COUNT(DISTINCT c.id_utilizador) 
                FROM pedidos p 
                INNER JOIN carrinhos c ON p.id_carrinho = c.id 
                WHERE DATE(p.dt_compra) = CURDATE() - INTERVAL 1 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    
    public function tshirtsSoldToday(): int {
        $sql = "SELECT COALESCE(SUM(pp2.quantidade), 0)
                FROM pedido_produtos pp2
                INNER JOIN pedidos p ON pp2.id_pedido = p.id
                INNER JOIN produtos pr ON pp2.id_produto = pr.id
                INNER JOIN produtos_pai pp ON pr.id_produto_pai = pp.id
                WHERE pp.tipo = 'Camisola' AND DATE(p.dt_compra) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    
    public function tshirtsSoldYesterday(): int {
        $sql = "SELECT COALESCE(SUM(pp2.quantidade), 0)
                FROM pedido_produtos pp2
                INNER JOIN pedidos p ON pp2.id_pedido = p.id
                INNER JOIN produtos pr ON pp2.id_produto = pr.id
                INNER JOIN produtos_pai pp ON pr.id_produto_pai = pp.id
                WHERE pp.tipo = 'Camisola' AND DATE(p.dt_compra) = CURDATE() - INTERVAL 1 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    
    public function pantsSoldToday(): int {
        $sql = "SELECT COALESCE(SUM(pp2.quantidade), 0)
                FROM pedido_produtos pp2
                INNER JOIN pedidos p ON pp2.id_pedido = p.id
                INNER JOIN produtos pr ON pp2.id_produto = pr.id
                INNER JOIN produtos_pai pp ON pr.id_produto_pai = pp.id
                WHERE pp.tipo = 'Calças' AND DATE(p.dt_compra) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    
    public function pantsSoldYesterday(): int {
        $sql = "SELECT COALESCE(SUM(pp2.quantidade), 0)
                FROM pedido_produtos pp2
                INNER JOIN pedidos p ON pp2.id_pedido = p.id
                INNER JOIN produtos pr ON pp2.id_produto = pr.id
                INNER JOIN produtos_pai pp ON pr.id_produto_pai = pp.id
                WHERE pp.tipo = 'Calças' AND DATE(p.dt_compra) = CURDATE() - INTERVAL 1 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function totalUsers(): int {
        $sql = "SELECT COUNT(*) FROM utilizadores";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function totalUsersYesterday(): int {
        $sql = "SELECT COUNT(*) FROM utilizadores WHERE DATE(created_at) <= CURDATE() - INTERVAL 1 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function usersRegisteredToday(): int {
        $sql = "SELECT COUNT(*) FROM utilizadores WHERE DATE(created_at) = CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function usersRegisteredYesterday(): int {
        $sql = "SELECT COUNT(*) FROM utilizadores WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function activeAccounts(): int {
        $sql = "SELECT COUNT(DISTINCT eu.id_utilizador) 
                FROM estado_utilizadores eu
                INNER JOIN estados e ON eu.id_estado = e.id
                WHERE e.nome_estado = 'Conta Ativa'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function activeAccountsYesterday(): int {
        $sql = "SELECT COUNT(DISTINCT eu.id_utilizador) 
                FROM estado_utilizadores eu
                INNER JOIN estados e ON eu.id_estado = e.id
                WHERE e.nome_estado = 'Conta Ativa'
                AND DATE(eu.data_alteracao) <= CURDATE() - INTERVAL 1 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function inactiveAccounts(): int {
        $sql = "SELECT COUNT(DISTINCT eu.id_utilizador) 
                FROM estado_utilizadores eu
                INNER JOIN estados e ON eu.id_estado = e.id
                WHERE e.nome_estado = 'Conta Inativa'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function inactiveAccountsYesterday(): int {
        $sql = "SELECT COUNT(DISTINCT eu.id_utilizador) 
                FROM estado_utilizadores eu
                INNER JOIN estados e ON eu.id_estado = e.id
                WHERE e.nome_estado = 'Conta Inativa'
                AND DATE(eu.data_alteracao) <= CURDATE() - INTERVAL 1 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    
    public function calcPercentage(int $today, int $yesterday): string {
        if ($yesterday === 0) {
            return $today > 0 ? '+100%' : '0%';
        }
        $diff = (($today - $yesterday) / $yesterday) * 100;
        $sign = $diff >= 0 ? '+' : '';
        return $sign . number_format($diff, 0) . '%';
    }

    public function getAllProductsPai(): array {
        $sql = "SELECT 
                    pp.id, pp.nome, 
                    pp.tipo, 
                    pp.cor, 
                    pp.image, 
                    pp.preco_venda,
                    AVG(p.preco_custo) AS preco_custo,
                    SUM(p.stock) AS stock
                FROM produtos_pai pp
                LEFT JOIN produtos p ON p.id_produto_pai = pp.id
                GROUP BY pp.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProducts(): array {
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
                0 AS sales,               
                0 AS revenue              
            FROM produtos p
            INNER JOIN produtos_pai pp ON p.id_produto_pai = pp.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inactiveUsersByPeriod(): array {
        $sql = "SELECT 
                    CASE
                        WHEN FLOOR(DATEDIFF(CURRENT_DATE, data_alteracao)) < 30 THEN 'Menos de 1 mês'
                        WHEN FLOOR(DATEDIFF(CURRENT_DATE, data_alteracao)) BETWEEN 30 AND 60 THEN '1 a 2 meses'
                        WHEN FLOOR(DATEDIFF(CURRENT_DATE, data_alteracao)) BETWEEN 60 AND 90 THEN '2 a 3 meses'
                        WHEN FLOOR(DATEDIFF(CURRENT_DATE, data_alteracao)) BETWEEN 90 AND 180 THEN '3 a 6 meses'
                        ELSE 'Mais de 6 meses'
                    END AS TempoInatividade,
                    COUNT(*) AS total_utilizadores
                FROM estado_utilizadores AS eu
                WHERE eu.id_estado = 10
                AND eu.data_alteracao = (
                    SELECT MAX(sub.data_alteracao)
                    FROM estado_utilizadores AS sub
                    WHERE sub.id_utilizador = eu.id_utilizador
                )
                GROUP BY TempoInatividade";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    
        // Organiza por chave para facilitar o acesso no PHP
        $result = [
            'Menos de 1 mês'  => 0,
            '1 a 2 meses'     => 0,
            '2 a 3 meses'     => 0,
            '3 a 6 meses'     => 0,
            'Mais de 6 meses' => 0,
        ];
    
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $result[$row['TempoInatividade']] = (int)$row['total_utilizadores'];
        }
    
        return $result;
    }

    public function deletedAccounts(): int {
        $sql = "SELECT COUNT(DISTINCT eu.id_utilizador) 
                FROM estado_utilizadores eu
                INNER JOIN estados e ON eu.id_estado = e.id
                WHERE e.nome_estado = 'Conta Apagada'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function deletedAccountsYesterday(): int {
        $sql = "SELECT COUNT(DISTINCT eu.id_utilizador) 
                FROM estado_utilizadores eu
                INNER JOIN estados e ON eu.id_estado = e.id
                WHERE e.nome_estado = 'Conta Apagada'
                AND DATE(eu.data_alteracao) <= CURDATE() - INTERVAL 1 DAY";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function topSellingProducts(): array {
        $sql = "
            SELECT 
                pp.id,
                pp.nome,
                pp.tipo,
                pp.cor,
                pp.image,
                pp.preco_venda,
                SUM(pp2.quantidade) AS total_vendido,
                SUM(pp2.quantidade * pp.preco_venda) AS receita
            FROM pedido_produtos pp2
            INNER JOIN produtos p ON pp2.id_produto = p.id
            INNER JOIN produtos_pai pp ON p.id_produto_pai = pp.id
            INNER JOIN pedidos pe ON pp2.id_pedido = pe.id
            GROUP BY pp.id
            ORDER BY total_vendido DESC
            LIMIT 5
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}