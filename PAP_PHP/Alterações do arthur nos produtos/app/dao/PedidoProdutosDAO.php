<?php

require_once __DIR__ . '/../models/PedidoProdutos.php';
require_once __DIR__ . '/../config/Database.php';

class PedidoProdutosDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToPedidoProdutos(array $row): PedidoProdutos {
        return new PedidoProdutos(
            id:         (int)$row['id'],
            id_pedido:  $row['id_pedido'],
            id_produto: $row['id_produto'],
            quantidade: (int)$row['quantidade']
        );
    }

    public function findPedidoProdutosByUserId($userId) {
        $sql = "
            SELECT 
                pedido_produtos.id,
                pedido_produtos.id_pedido,
                pedido_produtos.id_produto,
                pedido_produtos.quantidade,
                produtos.nome,
                produtos.preco_venda
            FROM pedido_produtos
            INNER JOIN produtos  ON pedido_produtos.id_produto = produtos.id
            INNER JOIN pedidos   ON pedido_produtos.id_pedido  = pedidos.id
            INNER JOIN carrinhos ON pedidos.id_carrinho        = carrinhos.id
            WHERE carrinhos.id_utilizador = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return false;
        }

        return $rows;
    }

    public function finalizarCompra(int $carrinhoId): int {
        try {
            $this->conn->beginTransaction();

            // verifica se o carrinho existe
            $stmtCarrinho = $this->conn->prepare("
                SELECT id FROM carrinhos WHERE id = ?
            ");
            $stmtCarrinho->execute([$carrinhoId]);
            $carrinho = $stmtCarrinho->fetch(PDO::FETCH_ASSOC);

            if (!$carrinho) {
                throw new Exception("Carrinho não encontrado.");
            }

            // cria o pedido
            $stmtPedido = $this->conn->prepare("
                INSERT INTO pedidos (id_carrinho, dt_compra)
                VALUES (?, NOW())
            ");
            $stmtPedido->execute([$carrinhoId]);
            $idPedido = (int) $this->conn->lastInsertId();

            // copia produtos do carrinho
            $stmtCopia = $this->conn->prepare("
                INSERT INTO pedido_produtos (id_pedido, id_produto, quantidade)
                SELECT ?, id_produto, quantidade
                FROM carrinho_produtos
                WHERE id_carrinho = ?
            ");
            $stmtCopia->execute([$idPedido, $carrinhoId]);

            if ($stmtCopia->rowCount() === 0) {
                throw new Exception("Carrinho está vazio.");
            }

            // limpa carrinho_produtos
            $stmtDeleteProdutos = $this->conn->prepare("
                DELETE FROM carrinho_produtos WHERE id_carrinho = ?
            ");
            $stmtDeleteProdutos->execute([$carrinhoId]);

            $this->conn->commit();

            return $idPedido;

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw new Exception("Erro ao finalizar compra: " . $e->getMessage());
        }
    }

}