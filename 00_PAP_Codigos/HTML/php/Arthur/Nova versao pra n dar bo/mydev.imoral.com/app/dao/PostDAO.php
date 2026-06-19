<?php

require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../config/Database.php';

class PostDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToPost(array $row): Post {
        return new Post(
            id:            (int)$row['id'],
            id_utilizador: (int)$row['id_utilizador'],
            dt_postagem:   $row['dt_postagem'],
            texto_post:    $row['texto_post'],
            like_count:    (int)$row['like_count']
        );
    }

    public function findPostById($postId) {
        $sql = "
            SELECT 
                id,
                id_utilizador,
                dt_postagem,
                texto_post,
                like_count
            FROM posts 
            WHERE id = ?
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $postId, PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if(!$row) {
            return false;
        }
    
        return $this->rowToPost($row); 
    }

    public function getAllPosts(): array {
        $sql = "
            SELECT 
                id,
                id_utilizador,
                dt_postagem,
                texto_post,
                like_count
            FROM posts
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];

        foreach($rows as $row) {
            $posts[] = $this->rowToPost($row); 
        }

        return $posts;
    }

     public function getPostsDao(): array {
        $sql = "
            SELECT 
                post.id,
                post.id_utilizador,
                post.dt_postagem,
                post.texto_post,
                post.like_count,
            FROM post 
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];

        foreach($rows as $row) {
            $posts[] = $this->rowToProduct($row);
        }

        return $posts;
    }

    public function createPost(Post $post) {
        $sql = "
            INSERT INTO posts (id_utilizador, dt_postagem, texto_post)
            VALUES (?, NOW(), ?);
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $post->getIdUtilizador(),
            $post->getTextoPost()
        ]);

        $id = $this->conn->lastInsertId();

        return $this->findPostById($id);
    }

    public function deletePost($postId, $userId): int {
        $sql = "
            DELETE FROM posts
            WHERE id = ? 
                AND id_utilizador = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $postId, PDO::PARAM_INT);
        $stmt->bindParam(2, $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function countPosts(): int {
        $sql = "
            SELECT COUNT(*) as num_posts 
            FROM posts
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function updatePost($postId, $textoPost): int {
    $sql = "
        UPDATE posts
        SET texto_post = ?
        WHERE id = ?
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$textoPost, $postId]);
    return $stmt->rowCount();
}
}