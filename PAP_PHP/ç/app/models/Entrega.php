<?php

require_once __DIR__ . '/BaseModel.php';

class Entrega extends BaseModel {
    protected $id;
    protected $id_pedido;
    protected $morada_entrega;
    protected $metodo_envio;
    protected $entregadora;
    protected $peso;
    protected $created_at;

    public function __construct(
        int $id = 0,
        int $id_pedido = 0,
        string $morada_entrega = '',
        string $metodo_envio = '',
        string $entregadora = '',
        float $peso = 0.0,
        string $created_at = ''
    ) {
        $this->id = $id;
        $this->id_pedido = $id_pedido;
        $this->morada_entrega = $morada_entrega;
        $this->metodo_envio = $metodo_envio;
        $this->entregadora = $entregadora;
        $this->peso = $peso;
        $this->created_at = $created_at;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdPedido(): int { return $this->id_pedido; }
    public function setIdPedido(int $id_pedido): void { $this->id_pedido = $id_pedido; }

    public function getMoradaEntrega(): string { return $this->morada_entrega; }
    public function setMoradaEntrega(string $morada_entrega): void { $this->morada_entrega = $morada_entrega; }

    public function getMetodoEnvio(): string { return $this->metodo_envio; }
    public function setMetodoEnvio(string $metodo_envio): void { $this->metodo_envio = $metodo_envio; }

    public function getEntregadora(): string { return $this->entregadora; }
    public function setEntregadora(string $entregadora): void { $this->entregadora = $entregadora; }

    public function getPeso(): float { return $this->peso; }
    public function setPeso(float $peso): void { $this->peso = $peso; }

    public function getCreatedAt(): string { return $this->created_at; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }
}