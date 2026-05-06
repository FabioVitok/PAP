USE imo_system;

DROP TABLE IF EXISTS estado_entregas;

CREATE TABLE estado_entregas (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_entrega INT(11) UNSIGNED NOT NULL,
    id_estado INT(11) UNSIGNED NOT NULL,
    data_alteracao DATETIME NULL,
    FOREIGN KEY (id_entrega) REFERENCES entregas(id),
    FOREIGN KEY (id_estado) REFERENCES estados(id)
);

INSERT INTO estado_entregas(id_entrega, id_estado, data_alteracao) VALUES
(1, 2, '2024-06-01 10:00:00'),
(1, 4, '2024-06-02 10:00:00'),
(1, 3, '2024-06-02 11:00:00'),
(2, 2, '2024-06-02 13:00:00'),
(2, 3, '2024-06-03 10:00:00'),
(3, 2, '2024-06-04 10:00:00'),
(3, 3, '2024-06-05 10:00:00'),
(4, 1, '2024-06-05 13:30:00'),
(5, 2, '2024-06-05 15:00:00'),
(5, 3, '2024-06-07 10:00:00'),
(6, 2, '2024-06-07 18:00:00'),
(6, 3, '2024-06-08 10:00:00'),
(7, 2, '2024-06-10 10:00:00'),
(7, 3, '2024-06-11 10:00:00'),
(8, 2, '2024-06-21 10:00:00'),
(8, 3, '2024-06-24 10:00:00'),
(9, 1, '2024-07-09 10:00:00'),
(10, 5, '2024-07-10 10:00:00');