USE imo_system;

DROP TABLE IF EXISTS wishlists;

CREATE TABLE wishlists (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL UNIQUE,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

INSERT INTO wishlists(id_utilizador) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20);