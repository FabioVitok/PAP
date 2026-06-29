<?php

require_once __DIR__ . '/BaseModel.php';

class Pagamento extends BaseModel {
    protected $id;
    protected $id_utilizador;
    protected $id_pedido;
    protected $metodo_pagamento;
    protected $valor;
    protected $created_at;

    public function __construct(
        int $id = 0,
        int $id_utilizador = 0,
        int $id_pedido = 0,
        string $metodo_pagamento = '',
        float $valor = 0.0,
        string $created_at = ''
    ) {
        $this->id = $id;
        $this->id_utilizador = $id_utilizador;
        $this->id_pedido = $id_pedido;
        $this->metodo_pagamento = $metodo_pagamento;
        $this->valor = $valor;
        $this->created_at = $created_at;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdUtilizador(): int { return $this->id_utilizador; }
    public function setIdUtilizador(int $id_utilizador): void { $this->id_utilizador = $id_utilizador; }

    public function getIdPedido(): int { return $this->id_pedido; }
    public function setIdPedido(int $id_pedido): void { $this->id_pedido = $id_pedido; }

    public function getMetodoPagamento(): string { return $this->metodo_pagamento; }
    public function setMetodoPagamento(string $metodo_pagamento): void { $this->metodo_pagamento = $metodo_pagamento; }

    public function getValor(): float { return $this->valor; }
    public function setValor(float $valor): void { $this->valor = $valor; }

    public function getCreatedAt(): string { return $this->created_at; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }
}