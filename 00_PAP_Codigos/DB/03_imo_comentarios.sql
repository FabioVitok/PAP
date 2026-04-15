USE imo_system;

DROP TABLE IF EXISTS comentarios;

CREATE TABLE comentarios (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_post INT(11) UNSIGNED NOT NULL,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    id_comentario_pai INT(11) UNSIGNED,
    dt_comentario DATETIME NOT NULL,
    texto_comentario VARCHAR(500) NOT NULL,
    like_count INT DEFAULT 0,
    FOREIGN KEY (id_post) REFERENCES posts(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    FOREIGN KEY (id_comentario_pai) REFERENCES comentarios(id)
);

INSERT INTO comentarios (id_post, id_utilizador, id_comentario_pai, dt_comentario, texto_comentario) VALUES
(1, 2, NULL, '2024-06-01 11:00:00', 'Concordo! Os produtos são incríveis.'),
(1, 3, 1, '2024-06-01 11:30:00', 'Também adoro esta loja!'),
(2, 1, NULL, '2024-06-02 13:00:00', 'Fico feliz que tenha gostado da entrega rápida!'),
(3, 2, NULL, '2024-06-03 16:00:00', 'Sim, os preços são muito competitivos.'),
(4, 3, NULL, '2024-06-04 10:00:00', 'Que bom que está satisfeita com a camisola!'),
(5, 1, NULL, '2024-06-05 15:00:00', 'O atendimento ao cliente é realmente excelente.'),
(6, 2, NULL, '2024-06-06 19:00:00', 'A variedade de produtos é um dos pontos fortes desta loja!');