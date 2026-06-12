<?php

require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../config/Database.php';

class PedidoDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToPedido(array $row): Pedido {
        return new Pedido(
            id:            (int)$row['id'],
            id_utilizador: $row['id_utilizador'],
            custo_total:    $row['custo_total']
        );
    }

    public function findPedidoById($pedidoId) {
        $sql = "
            SELECT 
                pedidos.id,
                pedidos.id_utilizador,
                pedidos.custo_total
            FROM pedidos
            WHERE pedidos.id = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $pedidoId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return false;
        }

        return $this->rowToPedido($row);
    }

    public function arrayCarrinhoProdutosDAO() {
        $sql = "
            SELECT
                pedido_produtos.id,
                pedido_produtos.id_pedido,
                pedido_produtos.id_produto,
                pedido_produtos.quantidade,
                pedido_produtos.dt_adicao
            FROM pedido_produtos;
        ";
    
        $stmt = $this->conn->prepare($sql);
    
        $stmt->execute();
    
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $rows;
    }

    public function createPedido(int $idUtilizador, float $custoTotal) {
        $sql = "
            INSERT INTO pedidos (id_utilizador, custo_total)
            VALUES (?, ?);
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUtilizador, $custoTotal]);

        return $this->conn->lastInsertId();
    }
}