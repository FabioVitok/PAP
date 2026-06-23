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
            username:      $row['username'] ?? null,
            image:         $row['image'] ?? null,
            comment_count: (int)($row['comment_count'] ?? 0) 
        );
    }

    public function findPostById($postId) {
        $sql = "
          SELECT 
            p.id,
            p.id_utilizador,
            u.username,
            u.image,
            p.dt_postagem,
            p.texto_post,
            COUNT(pl.id) as like_count,
            COUNT(c.id) as comment_count
        FROM posts as p
        LEFT JOIN post_likes as pl ON pl.id_post = p.id
        INNER JOIN utilizadores as u ON p.id_utilizador = u.id
        LEFT JOIN comentarios as c ON c.id_post = p.id
        WHERE p.id = ?
        GROUP BY p.id
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
            p.id,
            p.id_utilizador,
            u.username,
            u.image,
            p.dt_postagem,
            p.texto_post,
            p.created_at,
            p.updated_at,
            p.deleted_at,
            COUNT(pl.id) as like_count,
            COUNT(c.id) as comment_count
        FROM posts as p
        LEFT JOIN post_likes as pl ON pl.id_post = p.id
        INNER JOIN utilizadores as u ON p.id_utilizador = u.id
        LEFT JOIN comentarios as c ON c.id_post = p.id
        GROUP BY p.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     public function getPostsDao(): array {
        $sql = "
           SELECT 
            p.id,
            p.id_utilizador,
            u.username,
            u.image,
            p.dt_postagem,
            p.texto_post,
            p.created_at,
            p.updated_at,
            p.deleted_at,
            COUNT(pl.id) as like_count,
            COUNT(c.id) as comment_count
        FROM posts as p
        LEFT JOIN post_likes as pl ON pl.id_post = p.id
        INNER JOIN utilizadores as u ON p.id_utilizador = u.id
        LEFT JOIN comentarios as c ON c.id_post = p.id
        GROUP BY p.id
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