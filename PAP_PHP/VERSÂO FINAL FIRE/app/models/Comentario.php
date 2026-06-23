<?php

class Comentario {
    private int $id;
    private int $id_post;
    private int $id_utilizador;
    private ?int $id_comentario_pai;
    private string $dt_comentario;
    private string $texto_comentario;
    private int $like_count;
    private int $comment_count;
    private ?string $username;
    private ?string $image;

    public function __construct(
        int $id = 0,
        int $id_post = 0,
        int $id_utilizador = 0,
        ?int $id_comentario_pai = null,
        string $dt_comentario = '',
        string $texto_comentario = '',
        int $like_count = 0,
        int $comment_count = 0,
        ?string $username = null,
        ?string $image = null
    ) {
        $this->id                = $id;
        $this->id_post           = $id_post;
        $this->id_utilizador     = $id_utilizador;
        $this->id_comentario_pai = $id_comentario_pai;
        $this->dt_comentario     = $dt_comentario;
        $this->texto_comentario  = $texto_comentario;
        $this->like_count        = $like_count;
        $this->comment_count     = $comment_count;
        $this->username          = $username;
        $this->image             = $image;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdPost(): int { return $this->id_post; }
    public function setIdPost(int $id_post): void { $this->id_post = $id_post; }

    public function getIdUtilizador(): int { return $this->id_utilizador; }
    public function setIdUtilizador(int $id_utilizador): void { $this->id_utilizador = $id_utilizador; }

    public function getIdComentarioPai(): ?int { return $this->id_comentario_pai; }
    public function setIdComentarioPai(?int $id_comentario_pai): void { $this->id_comentario_pai = $id_comentario_pai; }

    public function getDtComentario(): string { return $this->dt_comentario; }
    public function setDtComentario(string $dt_comentario): void { $this->dt_comentario = $dt_comentario; }

    public function getTextoComentario(): string { return $this->texto_comentario; }
    public function setTextoComentario(string $texto_comentario): void { $this->texto_comentario = $texto_comentario; }

    public function getLikeCount(): int { return $this->like_count; }
    public function setLikeCount(int $like_count): void { $this->like_count = $like_count; }

    public function getCommentCount(): int { return $this->comment_count; }
    public function setCommentCount(int $comment_count): void { $this->comment_count = $comment_count; }

    public function getUsername(): ?string { return $this->username; }
    public function getImage(): ?string { return $this->image; }

    public function toArray(): array {
        return [
            'id'                => $this->id,
            'id_post'           => $this->id_post,
            'id_utilizador'     => $this->id_utilizador,
            'id_comentario_pai' => $this->id_comentario_pai,
            'dt_comentario'     => $this->dt_comentario,
            'texto_comentario'  => $this->texto_comentario,
            'like_count'        => $this->like_count,
            'comment_count'     => $this->comment_count,
            'username'          => $this->username,
            'image'             => $this->image
        ];
    }
}