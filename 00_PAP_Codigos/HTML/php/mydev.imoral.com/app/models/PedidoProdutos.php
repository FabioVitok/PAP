<?php

require_once __DIR__ . '/BaseModel.php';

class PedidoProdutos extends BaseModel {
    protected $id;
    protected $id_pedido;
    protected $id_produto;
    protected $quantidade;

    public function __construct(
        int $id = 0,
        string $id_pedido = '',
        string $id_produto = '',
        int $quantidade = 0
    ) {
        $this->id = $id;
        $this->id_pedido = $id_pedido;
        $this->id_produto = $id_produto;
        $this->quantidade = $quantidade;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdPedido(): string { return $this->id_pedido; }
    public function setIdPedido(string $id_pedido): void { $this->id_pedido = $id_pedido; }

    public function getIdProduto(): string { return $this->id_produto; }
    public function setIdProduto(string $id_produto): void { $this->id_produto = $id_produto; }

    public function getQuantidade(): int { return $this->quantidade; }
    public function setQuantidade(int $quantidade): void { $this->quantidade = $quantidade; }
}