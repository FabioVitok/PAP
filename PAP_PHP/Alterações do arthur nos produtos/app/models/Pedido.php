<?php

require_once __DIR__ . '/BaseModel.php';

class Pedido extends BaseModel {
    protected $id;
    protected $id_carrinho;
    protected $dt_compra;

    public function __construct(
        int $id = 0,
        string $id_carrinho = '',
        string $dt_compra = ''
    ) {
        $this->id = $id;
        $this->id_carrinho = $id_carrinho;
        $this->dt_compra = $dt_compra;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdCarrinho(): string { return $this->id_carrinho; }
    public function setIdCarrinho(string $id_carrinho): void { $this->id_carrinho = $id_carrinho; }

    public function getDtCompra(): string { return $this->dt_compra; }
    public function setDtCompra(string $dt_compra): void { $this->dt_compra = $dt_compra; }
}