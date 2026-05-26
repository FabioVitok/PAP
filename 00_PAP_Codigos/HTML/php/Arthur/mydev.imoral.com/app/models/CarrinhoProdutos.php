<?php

class CarrinhoProdutos {
    private int $id;
    private string $id_carrinho;
    private string $id_produto;
    private int $quantidade;
    private string $dt_adicao;

    public function __construct(
        int $id = 0,
        string $id_carrinho = '',
        string $id_produto = '',
        int $quantidade = 0,
        string $dt_adicao = ''
    ) {
        $this->id = $id;
        $this->id_carrinho = $id_carrinho;
        $this->id_produto = $id_produto;
        $this->quantidade = $quantidade;
        $this->dt_adicao = $dt_adicao;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdCarrinho(): string { return $this->id_carrinho; }
    public function setIdCarrinho(string $id_carrinho): void { $this->id_carrinho = $id_carrinho; }

    public function getIdProduto(): string { return $this->id_produto; }
    public function setIdProduto(string $id_produto): void { $this->id_produto = $id_produto; }

    public function getQuantidade(): int { return $this->quantidade; }
    public function setQuantidade(int $quantidade): void { $this->quantidade = $quantidade; }

    public function getDtAdicao(): string { return $this->dt_adicao; }
    public function setDtAdicao(string $dt_adicao): void { $this->dt_adicao = $dt_adicao; }
}
