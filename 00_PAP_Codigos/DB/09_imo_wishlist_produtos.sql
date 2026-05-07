USE imo_system;

DROP TABLE IF EXISTS wishlist_produtos;

CREATE TABLE wishlist_produtos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_wishlist INT(11) UNSIGNED NOT NULL,
    id_produto INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (id_wishlist) REFERENCES wishlists(id),
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);

INSERT INTO wishlist_produtos(id_wishlist, id_produto) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(7, 8),
(5, 9);

INSERT INTO wishlist_produtos(id_wishlist, id_produto) VALUES
(10, 1),
(10, 2),
(12, 3),
(12, 4),
(13, 5),
(13, 6),
(14, 7),
(14, 8),
(16, 8),
(17, 9);
