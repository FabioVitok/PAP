<?php

require_once __DIR__ . '/BaseModel.php';

class Product extends BaseModel {
    protected int $id;
    protected string $nome;
    protected string $tamanho;
    protected float $peso;
    protected string $tipo;
    protected ?string $cor;
    protected string $image;
    protected float $preco_venda;
    protected float $preco_custo;
    protected int $stock;

    public function __construct(
        int $id = 0,
        string $nome = '',
        string $tamanho = '',
        float $peso = 0.0,
        string $tipo = '',
        ?string $cor = null,
        string $image = '',
        float $preco_venda = 0.0,
        float $preco_custo = 0.0,
        int $stock = 0
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->tamanho = $tamanho;
        $this->peso = $peso;
        $this->tipo = $tipo;
        $this->cor = $cor;
        $this->image = $image;
        $this->preco_venda = $preco_venda;
        $this->preco_custo = $preco_custo;
        $this->stock = $stock;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = $nome; }

    public function getTamanho(): string { return $this->tamanho; }
    public function setTamanho(string $tamanho): void { $this->tamanho = $tamanho; }

    public function getPeso(): float { return $this->peso; }
    public function setPeso(float $peso): void { $this->peso = $peso; } 

    public function getTipo(): string { return $this->tipo; }
    public function setTipo(string $tipo): void { $this->tipo = $tipo; }

    public function getCor(): ?string { return $this->cor; }
    public function setCor(?string $cor): void { $this->cor = $cor; }

    public function getImage(): string { return $this->image; }
    public function setImage(string $image): void { $this->image = $image; }

    public function getPrecoVenda(): float { return $this->preco_venda; }
    public function setPrecoVenda(float $preco_venda): void { $this->preco_venda = $preco_venda; }

    public function getPrecoCusto(): float { return $this->preco_custo; }
    public function setPrecoCusto(float $preco_custo): void { $this->preco_custo = $preco_custo; }

    public function getStock(): int { return $this->stock; }
    public function setStock(int $stock): void { $this->stock = $stock; }
}
