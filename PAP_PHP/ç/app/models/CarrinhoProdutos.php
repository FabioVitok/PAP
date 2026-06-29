<?php

class CarrinhoProdutos extends BaseModel {
    protected int $id;
    protected string $id_carrinho;
    protected string $id_produto;
    protected int $quantidade;
    protected string $created_at;
    protected ?string $updated_at;

    public function __construct(
        int $id = 0,
        string $id_carrinho = '',
        string $id_produto = '',
        int $quantidade = 0,
        string $created_at = '',
        ?string $updated_at = ''
    ) {
        $this->id = $id;
        $this->id_carrinho = $id_carrinho;
        $this->id_produto = $id_produto;
        $this->quantidade = $quantidade;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdCarrinho(): string { return $this->id_carrinho; }
    public function setIdCarrinho(string $id_carrinho): void { $this->id_carrinho = $id_carrinho; }

    public function getIdProduto(): string { return $this->id_produto; }
    public function setIdProduto(string $id_produto): void { $this->id_produto = $id_produto; }

    public function getQuantidade(): int { return $this->quantidade; }
    public function setQuantidade(int $quantidade): void { $this->quantidade = $quantidade; }

    public function getCreated_at(): string { return $this->created_at; }
    public function setCreated_at(string $created_at): void { $this->created_at = $created_at; }

    public function getUpdated_at(): string { return $this->updated_at; }
    public function setUpdated_at(string $updated_at): void { $this->updated_at = $updated_at; }
}
