<?php

class WishlistProdutos extends BaseModel {
    protected int $id;
    protected string $id_wishlist;
    protected string $id_produtopai;
    protected string $created_at;

    public function __construct(
        int $id = 0,
        string $id_wishlist = '',
        string $id_produtopai = '',
        string $created_at = ''
    ) {
        $this->id = $id;
        $this->id_wishlist = $id_wishlist;
        $this->id_produtopai = $id_produtopai;
        $this->created_at = $created_at;
    }

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getIdWishlist(): string { return $this->id_wishlist; }
    public function setIdWishlist(string $id_wishlist): void { $this->id_wishlist = $id_wishlist; }

    public function getIdProdutopai(): string { return $this->id_produtopai; }
    public function setIdProdutopai(string $id_produtopai): void { $this->id_produtopai = $id_produtopai; }

    public function getCreatedAt(): int { return $this->created_at; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }
}
