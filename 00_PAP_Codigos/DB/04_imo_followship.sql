USE imo_system;

DROP TABLE IF EXISTS followship;

CREATE TABLE followship (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_seguidor INT(11) UNSIGNED NOT NULL,
    id_seguido INT(11) UNSIGNED NOT NULL,
    dt_seguimento DATETIME NOT NULL,
    FOREIGN KEY (id_seguidor) REFERENCES utilizadores(id),
    FOREIGN KEY (id_seguido) REFERENCES utilizadores(id)
);