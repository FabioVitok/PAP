<?php

require_once __DIR__ . '/../models/Carrinho.php';
require_once __DIR__ . '/../config/Database.php';

class CarrinhoDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToCarrinho(array $row): Carrinho {
        return new Carrinho(
            id:            (int)$row['id'],
            id_utilizador: $row['id_utilizador'],
            custo_total:    $row['custo_total']
        );
    }

    public function findCarrinhoById($carrinhoId) {
        $sql = "
            SELECT 
                carrinhos.id,
                carrinhos.id_utilizador,
                carrinhos.custo_total
            FROM carrinhos
            WHERE carrinhos.id_utilizador = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $carrinhoId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return false;
        }

        return $this->rowToCarrinho($row);
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
/** 
    public function createCarrinhoProduto(CarrinhoProduto $carrinhoProduto) {
        $sql = "
            INSERT INTO carrinho_produtos (id_carrinho, id_produto, quantidade)
            VALUES (?, ?, ?);
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(
            $carrinhoProduto->getIdCarrinho(),
            $carrinhoProduto->getIdProduto(),
            $carrinhoProduto->getQuantidade()
        );

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
*/
}