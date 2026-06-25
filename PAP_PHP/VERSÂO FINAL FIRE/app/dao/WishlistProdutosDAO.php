<?php

require_once __DIR__ . '/../models/WishlistProdutos.php';
require_once __DIR__ . '/../config/Database.php';

class WishlistProdutosDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToWishlistProdutos(array $row): WishlistProdutos {
        return new WishlistProdutos(
            id:            (int)$row['id'],
            id_wishlist:   $row['id_wishlist'],
            id_produtopai: $row['id_produtopai'],
            created_at:    $row['created_at']
        );
    }

    public function findWishlistProdutoById($id) {
        $sql = "
            SELECT
                wishlist_produtos.id,
                wishlist_produtos.id_wishlist,
                wishlist_produtos.id_produtopai,
                wishlist_produtos.created_at
            FROM wishlist_produtos
            WHERE wishlist_produtos.id = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return false;
        }

        return $this->rowToWishlistProdutos($row);
    }   

    public function findWishlistProdutosByUserId($userId){
        $sql = "
            SELECT 
                wishlist_produtos.id,
                wishlist_produtos.id_wishlist AS id_wishlist,
                wishlist_produtos.id_produtopai AS id_produtopai,
                wishlist_produtos.created_at,
            FROM wishlist_produtos
            INNER JOIN produtospai ON wishlist_produtos.id_produtopai = produtospai.id
            INNER JOIN wishlists ON wishlist_produtos.id_wishlist = wishlists.id
            INNER JOIN utilizadores ON wishlists.id_utilizador = utilizadores.id
            WHERE utilizadores.id = ?;
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
 
    public function createWishlistProduto(WishlistProdutos $wishlistProduto) {
        $sql = "
            INSERT INTO wishlist_produtos (id_wishlist, id_produtopai)
            VALUES (?, ?);
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $wishlistProduto->getIdWishlist(),
            $wishlistProduto->getIdProdutopai()
        ]);
    
        $id = $this->conn->lastInsertId();
    
        return $this->findWishlistProdutoById($id);
    }

    public function updateQtdWishlistProduto($wishlistProdutoId, $userId, $novaQuantidade) {
        $sql = "
            UPDATE wishlist_produtos
            INNER JOIN wishlists ON wishlist_produtos.id_wishlist = wishlists.id
            SET wishlist_produtos.quantidade = ?
            WHERE wishlist_produtos.id = ? 
                AND wishlists.id_utilizador = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $novaQuantidade, PDO::PARAM_INT);
        $stmt->bindParam(2, $wishlistProdutoId, PDO::PARAM_INT);
        $stmt->bindParam(3, $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function deleteWishlistProduto($wishlistProdutoId, $userId) {
        $sql = "
            DELETE wishlist_produtos 
            FROM wishlist_produtos
            INNER JOIN wishlists ON wishlist_produtos.id_wishlist = wishlists.id
            WHERE wishlist_produtos.id = ? 
                AND wishlists.id_utilizador = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $wishlistProdutoId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount();
    }
}
