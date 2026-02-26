USE imo_system;

DROP TABLE IF EXISTS estado_entregas;

CREATE TABLE estado_entregas (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_entrega INT(11) UNSIGNED NOT NULL,
    id_estado INT(11) UNSIGNED NOT NULL,
    data_alteracao DATE NULL,
    FOREIGN KEY (id_entrega) REFERENCES entregas(id),
    FOREIGN KEY (id_estado) REFERENCES estados(id)
);