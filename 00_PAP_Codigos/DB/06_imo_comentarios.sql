USE imo_system;

DROP TABLE IF EXISTS comentarios;

CREATE TABLE comentarios (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_post INT(11) UNSIGNED NOT NULL,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    id_comentario_pai INT(11) UNSIGNED,
    texto_comentario VARCHAR(500) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_post) REFERENCES posts(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    FOREIGN KEY (id_comentario_pai) REFERENCES comentarios(id)
);

DROP TABLE IF EXISTS comentario_likes;

CREATE TABLE comentario_likes (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_comentario INT(11) UNSIGNED NOT NULL,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_comentario) REFERENCES posts(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    UNIQUE KEY unique_like (id_comentario, id_utilizador)
);

INSERT INTO comentarios (id_post, id_utilizador, id_comentario_pai, texto_comentario) VALUES
(1, 2, NULL, '2024-06-01 11:00:00', 'Tenho que exprimentar com rick owens também'),
(1, 3, 1, '2024-06-01 11:30:00', 'Ficou mesmo bem'),
(2, 1, NULL, '2024-06-02 13:00:00', 'Quase um cosplay lmaoo'),
(3, 2, NULL, '2024-06-03 16:00:00', 'Eu vou ya, este ano foi bom? Não consegui ir'),
(3, 3, 4, '2024-06-03 16:30:00', 'Eu fui e teve uns runways bons'),
(6, 2, NULL, '2024-06-06 19:00:00', 'O sonic blast é sempre top, o lineup deste ano está brutal');

INSERT INTO comentario_likes (id_comentario, id_utilizador, created_at) VALUES
(1, 2, '2024-06-01 11:00:00'),
(1, 3, '2024-06-01 11:30:00'),
(2, 1, '2024-06-02 13:00:00'),
(2, 3, '2024-06-02 13:30:00'),
(3, 1, '2024-06-03 16:00:00'),
(3, 2, '2024-06-03 16:30:00'),
(4, 1, '2024-06-04 10:00:00'),
(4, 3, '2024-06-04 10:30:00'),
(5, 2, '2024-06-05 15:00:00'),
(5, 3, '2024-06-05 15:30:00'),
(6, 1, '2024-06-06 19:00:00'),
(6, 2, '2024-06-06 19:30:00');