<?php

class CarrinhoProdutos extends BaseModel {
    protected int $id;
    protected string $id_carrinho;
    protected string $id_produtopai;
    protected int $created_at;

    public function __construct(
        int $id = 0,
        string $id_carrinho = '',
        string $id_produtopai = '',
        int $created_at = 0
    ) {
        $this->id = $id;
        $this->id_carrinho = $id_carrinho;
        $this->id_produtopai = $id_produtopai;
        $this->created_at = $created_at;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdCarrinho(): string { return $this->id_carrinho; }
    public function setIdCarrinho(string $id_carrinho): void { $this->id_carrinho = $id_carrinho; }

    public function getIdProdutopai(): string { return $this->id_produtopai; }
    public function setIdProdutopai(string $id_produtopai): void { $this->id_produtopai = $id_produtopai; }

    public function getCreatedAt(): int { return $this->created_at; }
    public function setCreatedAt(int $created_at): void { $this->created_at = $created_at; }
}
