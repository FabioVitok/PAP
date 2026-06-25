<?php

require_once __DIR__ . '/../models/Wishlist.php';
require_once __DIR__ . '/../config/Database.php';

class WishlistDAO{

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToWishlist(array $row): Wishlist {
        return new Wishlist(
            id:            (int)$row['id'],
            id_utilizador: $row['id_utilizador'],
        );
    }

    public function findWishlistById($wishlistId) {
        $sql = "
            SELECT 
                wishlists.id,
                wishlists.id_utilizador
            FROM wishlists
            WHERE wishlists.id = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $wishlistId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return false;
        }

        return $this->rowToWishlist($row);
    }

    public function findWishlistByUserId($userId) {
        $sql = "
            SELECT 
                wishlists.id,
                wishlists.id_utilizador
            FROM wishlists
            WHERE wishlists.id_utilizador = ?
            LIMIT 1;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->rowToWishlist($row) : false;
    }

    public function createWishlist($userId): int{
        $sql = "
            INSERT INTO wishlists (id_utilizador)
            VALUES (?);
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);

        $id = $this->conn->lastInsertId();

        return $id;
    }

    public function deleteWishlist($wishlistId, $userId) {
        $sql = "
            DELETE wishlists 
            FROM wishlists
            INNER JOIN utilizadores ON wishlists.id_utilizador = utilizadores.id
            WHERE wishlists.id = ? 
                AND utilizadores.id = ?;
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $wishlistId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}