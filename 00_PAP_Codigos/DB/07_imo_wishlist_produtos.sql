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
(5, 9);


INSERT INTO wishlist_produtos(id_wishlist, id_produto) VALUES
(11, 1),
(11, 3),
(12, 5),
(12, 7),
(13, 9),
(13, 11),
(14, 13),
(14, 15),
(15, 17),
(15, 19),
(16, 2),
(16, 4),
(17, 6),
(17, 8),
(18, 10),
(18, 12),
(19, 14),
(19, 16),
(20, 18),
(20, 20);

INSERT INTO wishlist_produtos(id_wishlist, id_produto) VALUES
(1, 3),
(1, 5),
(2, 7),
(2, 9),
(3, 11),
(3, 13),
(4, 15),
(4, 17),
(5, 19),
(5, 1),
(6, 2),
(6, 4),
(7, 6),
(7, 8),
(8, 10),
(8, 12),
(9, 14),
(9, 16),
(10, 18),
(10, 20);

INSERT INTO wishlist_produtos(id_wishlist, id_produto) VALUES
(11, 5),
(11, 10),
(12, 15),
(12, 20),
(13, 4),
(13, 8),
(14, 12),
(14, 16),
(15, 1),
(15, 6),
(16, 11),
(16, 17),
(17, 2),
(17, 9),
(18, 14),
(18, 19),
(19, 3),
(19, 7),
(20, 13),
(20, 18);