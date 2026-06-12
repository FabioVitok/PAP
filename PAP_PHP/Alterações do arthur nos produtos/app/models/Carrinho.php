<?php

require_once __DIR__ . '/BaseModel.php';

class Carrinho extends BaseModel {
protected int $id;
protected string $id_utilizador;
protected float $custo_total;

public function __construct(
    int $id = 0,
    string $id_utilizador = '',
    float $custo_total = 0.00
) {
    $this->id = $id;
    $this->id_utilizador = $id_utilizador;
    $this->custo_total = $custo_total;
}

public function getId(): int { return $this->id; }
public function setId(int $id): void { $this->id = $id; }

public function getIdUtilizador(): string { return $this->id_utilizador; }
public function setIdUtilizador(string $id_utilizador): void { $this->id_utilizador = $id_utilizador; }

public function getCustoTotal(): float { return $this->custo_total; }
public function setCustoTotal(float $custo_total): void { $this->custo_total = $custo_total; }

}