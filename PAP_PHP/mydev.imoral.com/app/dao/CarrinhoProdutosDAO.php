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

    public function findCarrinhoProdutoById($id) {
    $sql = "
        SELECT
            carrinho_produtos.id,
            carrinho_produtos.id_carrinho,
            carrinho_produtos.id_produto,
            carrinho_produtos.quantidade,
            carrinho_produtos.dt_adicao
        FROM carrinho_produtos
        WHERE carrinho_produtos.id = ?;
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$row) {
        return false;
    }

    return $this->rowToCarrinhoProdutos($row);
}

    public function findCarrinhoProdutosByUserId($userId){
        $sql = "
            SELECT 
                carrinho_produtos.id,
                carrinho_produtos.id_carrinho AS id_carrinho,
                carrinho_produtos.id_produto AS id_produto,
                carrinho_produtos.quantidade,
                produtos_pai.nome,
                produtos.tamanho,
                produtos_pai.preco_venda
            FROM carrinho_produtos
            INNER JOIN produtos ON carrinho_produtos.id_produto = produtos.id
            INNER JOIN produtos_pai ON produtos.id_produto_pai = produtos_pai.id
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

    public function createCarrinhoProduto(CarrinhoProdutos $carrinhoProduto) {
        $sql = "
            INSERT INTO carrinho_produtos (id_carrinho, id_produto, quantidade, dt_adicao)
            VALUES (?, ?, ?, NOW());
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $carrinhoProduto->getIdCarrinho(),
            $carrinhoProduto->getIdProduto(),
            $carrinhoProduto->getQuantidade()
        ]);

        $id = $this->conn->lastInsertId();

        return $this->findCarrinhoProdutoById($id);
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