USE imo_system;

DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    dt_postagem DATETIME NOT NULL,
    texto_post VARCHAR(1000) NOT NULL,
    like_count INT DEFAULT 0,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

INSERT INTO posts (id_utilizador, dt_postagem, texto_post) VALUES
(1, '2024-06-01 10:00:00', 'Adoro os produtos desta loja!'),
(2, '2024-06-02 12:30:00', 'A entrega foi super rápida, recomendo!'),
(3, '2024-06-03 15:45:00', 'Os preços são ótimos e a qualidade é excelente.'),
(1, '2024-06-04 09:20:00', 'Comprei uma camisola e estou muito satisfeita!'),
(2, '2024-06-05 14:10:00', 'O atendimento ao cliente foi muito eficiente.'),
(3, '2024-06-06 18:25:00', 'Adorei a variedade de produtos disponíveis.');