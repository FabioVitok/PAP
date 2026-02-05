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