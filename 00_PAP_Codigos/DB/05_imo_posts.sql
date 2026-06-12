USE imo_system;

DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    dt_postagem DATETIME NOT NULL,
    texto_post VARCHAR(1000) NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

CREATE TABLE post_likes (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_post INT(11) UNSIGNED NOT NULL,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    dt_like DATETIME NOT NULL,
    FOREIGN KEY (id_post) REFERENCES posts(id),
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    UNIQUE KEY unique_like (id_post, id_utilizador)
);

INSERT INTO posts (id_utilizador, dt_postagem, texto_post) VALUES
(1, '2024-06-01 10:00:00', 'Guys as calças novas ficam bue bem com new rocks'),
(2, '2024-06-02 12:30:00', 'Jojo inspired Outfit!'),
(3, '2024-06-03 15:45:00', 'Alguem vai ao moda lisboa ano que vem?'),
(1, '2024-06-04 09:20:00', 'Mala diy que comprei com uns patches extra que fiz'),
(2, '2024-06-05 14:10:00', 'Haul do que comprei na promoção da imoral'),
(3, '2024-06-06 18:25:00', 'Get ready with me para ir ao sonic blast');

INSERT INTO post_likes (id_post, id_utilizador, dt_like) VALUES
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

