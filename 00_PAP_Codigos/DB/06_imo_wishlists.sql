USE imo_system;

DROP TABLE IF EXISTS wishlists;

CREATE TABLE wishlists (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);