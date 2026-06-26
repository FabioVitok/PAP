<?php

require_once __DIR__ . '/BaseModel.php';

class ProductPai extends BaseModel {
    protected int $id;
    protected string $nome;
    protected string $tipo;
    protected ?string $cor;
    protected ?string $image;
    protected float $preco_venda;

    public function __construct(
        int $id = 0,
        string $nome = '',
        string $tipo = '',
        ?string $cor = null,
        ?string $image = null,
        float $preco_venda = 0.0
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->cor = $cor;
        $this->image = $image;
        $this->preco_venda = $preco_venda;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = $nome; }

    public function getTipo(): string { return $this->tipo; }
    public function setTipo(string $tipo): void { $this->tipo = $tipo; }

    public function getCor(): ?string { return $this->cor; }
    public function setCor(?string $cor): void { $this->cor = $cor; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): void { $this->image = $image; }

    public function getPrecoVenda(): float { return $this->preco_venda; }
    public function setPrecoVenda(float $preco_venda): void { $this->preco_venda = $preco_venda; }
}