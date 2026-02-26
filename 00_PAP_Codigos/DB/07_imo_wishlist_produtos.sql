USE imo_system;

DROP TABLE IF EXISTS wishlist_produtos;

CREATE TABLE wishlist_produtos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_wishlist INT(11) UNSIGNED NOT NULL,
    id_produto INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (id_wishlist) REFERENCES wishlists(id),
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);