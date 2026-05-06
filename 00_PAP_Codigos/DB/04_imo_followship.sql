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

INSERT INTO followship(id_seguidor, id_seguido, dt_seguimento) VALUES
(1, 2, '2024-02-01 10:00:00'),
(1, 3, '2024-02-02 11:00:00'),
(2, 1, '2024-02-03 12:00:00'),
(2, 3, '2024-02-03 13:00:00'),
(3, 1, '2024-02-03 14:00:00'),
(3, 2, '2024-02-06 15:00:00'),
(4, 1, '2024-02-07 16:00:00'),
(4, 2, '2024-02-08 17:00:00'),
(5, 1, '2024-02-09 18:00:00'),
(5, 2, '2024-02-10 19:00:00');

INSERT INTO followship(id_seguidor, id_seguido, dt_seguimento) VALUES
(16, 1, '2024-02-20 17:00:00'),
(16, 2, '2024-03-01 16:00:00'),
(17, 1, '2024-03-02 15:00:00'),
(17, 3, '2024-03-03 14:00:00'),
(18, 12, '2024-03-04 13:00:00'),
(18, 3, '2024-03-05 12:00:00'),
(19, 11, '2024-03-06 11:00:00'),
(19, 2, '2024-03-07 10:00:00'),
(19, 14, '2024-03-08 09:00:00'),
(19, 10, '2024-03-09 08:00:00');

INSERT INTO followship(id_seguidor, id_seguido, dt_seguimento) VALUES
(1, 10, '2024-03-09 10:00:00'),
(2, 10, '2024-03-09 11:00:00'),
(3, 10, '2024-03-09 12:00:00'),
(4, 10, '2024-03-09 13:00:00'),
(5, 10, '2024-03-09 14:00:00'),
(6, 10, '2024-03-09 15:00:00'),
(7, 10, '2024-03-09 16:00:00'),
(8, 10, '2024-03-09 17:00:00'),
(9, 10, '2024-03-10 18:00:00'),
(10, 10, '2024-03-10 19:00:00');
