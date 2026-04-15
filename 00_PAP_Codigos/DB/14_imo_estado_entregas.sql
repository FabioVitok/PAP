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

INSERT INTO estado_entregas(id_entrega, id_estado, data_alteracao) VALUES
(1, 1, '2024-06-01'),
(2, 2, '2024-06-02'),
(3, 3, '2024-06-03'),
(4, 4, '2024-06-04'),
(5, 5, '2024-06-05'),
(6, 1, '2024-06-06'),
(7, 2, '2024-06-07'),
(8, 3, '2024-06-08'),
(9, 4, '2024-06-09'),
(10, 5, '2024-06-10');