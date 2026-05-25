<?php

require_once __DIR__ . '/../models/CarrinhoProdutos.php';
require_once __DIR__ . '/../config/Database.php';

class CarrinhoProdutosDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToCarrinhoProdutos(array $row): CarrinhoProdutos {
        return new CarrinhoProdutos(
            id:            (int)$row['id'],
            id_carrinho:   $row['id_carrinho'],
            id_produto:    $row['id_produto'],
            quantidade:    (int)$row['quantidade'],
            dt_adicao:     $row['dt_adicao']
        );
    }

    public function findCarrinhoProdutosByUserId($userId){
        $sql = "
            SELECT 
                carrinho_produtos.id,
                carrinho_produtos.id_carrinho AS id_carrinho,
                carrinho_produtos.id_produto AS id_produto,
                carrinho_produtos.quantidade,
                produtos.nome,
                produtos.tamanho,
                produtos.preco_venda
            FROM carrinho_produtos
            INNER JOIN produtos ON carrinho_produtos.id_produto = produtos.id
            INNER JOIN carrinhos ON carrinho_produtos.id_carrinho = carrinhos.id
            INNER JOIN utilizadores ON carrinhos.id_utilizador = utilizadores.id
            WHERE carrinhos.id_utilizador = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if(!$row) {
            return false;
        }
    
        return $row;
    }
 
    public function arrayCarrinhoProdutosDAO() {
        $sql = "
            SELECT
                carrinho_produtos.id,
                carrinho_produtos.id_carrinho,
                carrinho_produtos.id_produto,
                carrinho_produtos.quantidade,
                carrinho_produtos.dt_adicao
            FROM carrinho_produtos;
        ";
    
        $stmt = $this->conn->prepare($sql);
    
        $stmt->execute();
    
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $rows;
    }

    public function deleteCarrinhoProduto($carrinhoProdutoId, $userId) {
        $sql = "
            DELETE carrinho_produtos 
            FROM carrinho_produtos
            INNER JOIN carrinhos ON carrinho_produtos.id_carrinho = carrinhos.id
            WHERE carrinho_produtos.id = ? 
                AND carrinhos.id_utilizador = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $carrinhoProdutoId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}