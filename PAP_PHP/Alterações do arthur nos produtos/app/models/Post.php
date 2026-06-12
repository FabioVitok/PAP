<?php

class Post {
    private int $id;
    private int $id_utilizador;
    private String $dt_postagem;
    private String $texto_post;
    private int $like_count;

    public function __construct(
        int $id = 0,
        int $id_utilizador = 0,
        string $dt_postagem = '',
        string $texto_post = '',
        int $like_count = 0
    ) {
        $this->id = $id;
        $this->id_utilizador = $id_utilizador;
        $this->dt_postagem = $dt_postagem;
        $this->texto_post = $texto_post;
        $this->like_count = $like_count;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    
    public function getIdUtilizador(): int { return $this->id_utilizador; }
    public function setIdUtilizador(int $id_utilizador): void { $this->id_utilizador = $id_utilizador; }

    public function getDtPostagem(): string { return $this->dt_postagem; }
    public function setDtPostagem(string $dt_postagem ): void { $this->dt_postagem = $dt_postagem; }

    public function getTextoPost(): string { return $this->texto_post; }
    public function setTextoPost(string $texto_post): void { $this->texto_post = $texto_post; }

    public function getLikeCount(): int { return $this->like_count; }
    public function setLikeCount(int $like_count): void { $this->like_count = $like_count; }

    public function toArray(): array {
    return [
        'id'            => $this->id,
        'id_utilizador' => $this->id_utilizador,
        'dt_postagem'   => $this->dt_postagem,
        'texto_post'    => $this->texto_post,
        'like_count'    => $this->like_count
    ];
}
}
