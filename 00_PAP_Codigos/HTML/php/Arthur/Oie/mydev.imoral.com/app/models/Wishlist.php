<?php

class Wishlist extends BaseModel {
protected int $id;
protected string $id_utilizador;

public function __construct(
    int $id = 0,
    string $id_utilizador = '',
) {
    $this->id = $id;
    $this->id_utilizador = $id_utilizador;
}

public function getId(): int { return $this->id; }
public function setId(int $id): void { $this->id = $id; }

public function getIdUtilizador(): string { return $this->id_utilizador; }
public function setIdUtilizador(string $id_utilizador): void { $this->id_utilizador = $id_utilizador; }

}