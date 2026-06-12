<?php

require_once __DIR__ . '/BaseModel.php';

class Product extends BaseModel {
    protected int $id;
    protected int $id_produto_pai;
    protected string $tamanho;
    protected float $peso;
    protected float $preco_custo;
    protected int $stock;

    public function __construct(
        int $id = 0,
        int $id_produto_pai = 0,
        string $tamanho = '',
        float $peso = 0.0,
        float $preco_custo = 0.0,
        int $stock = 0
    ) {
        $this->id = $id;
        $this->id_produto_pai = $id_produto_pai;
        $this->tamanho = $tamanho;
        $this->peso = $peso;
        $this->preco_custo = $preco_custo;
        $this->stock = $stock;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdProdutoPai(): int { return $this->id_produto_pai; }
    public function setIdProdutoPai(int $id_produto_pai): void { $this->id_produto_pai = $id_produto_pai; }

    public function getTamanho(): string { return $this->tamanho; }
    public function setTamanho(string $tamanho): void { $this->tamanho = $tamanho; }

    public function getPeso(): float { return $this->peso; }
    public function setPeso(float $peso): void { $this->peso = $peso; }

    public function getPrecoCusto(): float { return $this->preco_custo; }
    public function setPrecoCusto(float $preco_custo): void { $this->preco_custo = $preco_custo; }

    public function getStock(): int { return $this->stock; }
    public function setStock(int $stock): void { $this->stock = $stock; }
}