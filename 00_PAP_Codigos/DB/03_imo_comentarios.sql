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