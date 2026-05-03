USE imo_system;

DROP TABLE IF EXISTS estado_contas;

CREATE TABLE estado_contas (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    id_estado INT(11) UNSIGNED NOT NULL,
    data_alteracao DATE NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    FOREIGN KEY (id_estado) REFERENCES estados(id)
);

INSERT INTO estado_contas(id_utilizador, id_estado, data_alteracao) VALUES
(1, 6, '2024-06-01'),
(2, 6, '2024-06-02'),
(3, 7, '2024-06-03'),
(4, 6, '2024-06-04'),
(5, 8, '2024-06-05'),
(6, 9, '2024-06-06'),
(7, 9, '2024-06-07'),
(8, 9, '2024-06-08'),
(9, 8, '2024-06-09'),
(10, 7, '2024-06-10'),
(7, 10, '2024-06-07'),
(8, 10, '2024-06-08'),
(9, 10, '2024-08-09'),
(10, 9, '2024-07-11');