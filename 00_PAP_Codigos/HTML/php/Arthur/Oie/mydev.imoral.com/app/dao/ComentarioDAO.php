<?php

require_once __DIR__ . '/../models/Comentario.php';
require_once __DIR__ . '/../config/Database.php';

class ComentarioDAO {   

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToComentario(array $row): Comentario {
    return new Comentario(
        id:                (int)$row['id'],
        id_post:           (int)$row['id_post'],
        id_utilizador:     (int)$row['id_utilizador'],
        id_comentario_pai: $row['id_comentario_pai'] ?? null,
        dt_comentario:     $row['dt_comentario'],
        texto_comentario:  $row['texto_comentario'],
        like_count:    (int)$row['like_count'],
        comment_count: (int)($row['comment_count'] ?? 0),
        username:      $row['username'] ?? null,
        image:         $row['image'] ?? null
        );
    }


    public function getComentariosByPostId($postId): array {
        $sql = "
            SELECT 
            c.id,
            c.id_post,
            c.id_utilizador,
            u.username,
            u.image,
            c.dt_comentario,
            c.texto_comentario,
            c.like_count,
            COUNT(r.id) as reply_count
        FROM comentarios as c
        INNER JOIN utilizadores as u ON c.id_utilizador = u.id
        LEFT JOIN comentarios as r ON r.id_comentario_pai = c.id
        WHERE c.id_post = ? AND c.id_comentario_pai IS NULL
        GROUP BY c.id
        ORDER BY c.dt_comentario ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $postId, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $comments = [];

        foreach($rows as $row) {
            $comments[] = $this->rowToComentario($row);
        }

        return $comments;
    }

    public function getRespostasByComentarioId($CommentId): array {
        $sql = "
            SELECT 
            c.id,
            c.id_post,
            c.id_utilizador,
            c.id_comentario_pai,
            u.username,
            u.image,
            c.dt_comentario,
            c.texto_comentario,
            c.like_count
        FROM comentarios as c
        INNER JOIN utilizadores as u ON c.id_utilizador = u.id
        WHERE c.id_comentario_pai = ?
        GROUP BY c.id
        ORDER BY c.dt_comentario ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $CommentId, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $comments = [];

        foreach($rows as $row) {
            $comments[] = $this->rowToComentario($row);
        }

        return $comments;
    }

}