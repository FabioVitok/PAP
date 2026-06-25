USE imo_system;

DROP TABLE IF EXISTS comentarios;

CREATE TABLE comentarios (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_post INT(11) UNSIGNED NOT NULL,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    id_comentario_pai INT(11) UNSIGNED,
    dt_comentario DATETIME NOT NULL,
    texto_comentario VARCHAR(500) NOT NULL,
    FOREIGN KEY (id_post) REFERENCES posts(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    FOREIGN KEY (id_comentario_pai) REFERENCES comentarios(id)
);

INSERT INTO comentarios (id_post, id_utilizador, id_comentario_pai, dt_comentario, texto_comentario) VALUES
(1, 2, NULL, '2024-06-01 11:00:00', 'Tenho que exprimentar com rick owens também'),
(1, 3, 1, '2024-06-01 11:30:00', 'Ficou mesmo bem'),
(2, 1, NULL, '2024-06-02 13:00:00', 'Quase um cosplay lmaoo'),
(3, 2, NULL, '2024-06-03 16:00:00', 'Eu vou ya, este ano foi bom? Não consegui ir'),
(3, 3, 4, '2024-06-03 16:30:00', 'Eu fui e teve uns runways bons'),
(6, 2, NULL, '2024-06-06 19:00:00', 'O sonic blast é sempre top, o lineup deste ano está brutal');