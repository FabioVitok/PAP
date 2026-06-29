USE imo_system;

DROP TABLE IF EXISTS utilizadores;

CREATE TABLE utilizadores (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    image VARCHAR(255) NOT NULL DEFAULT 'assets/images/users/user_icon.png',
    telefone VARCHAR(14) UNIQUE,
    password VARCHAR(255) NOT NULL,
    morada VARCHAR(255) NOT NULL DEFAULT '',
    dt_nascimento DATE NULL,
    dt_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    pronomes VARCHAR(20),
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    ultimo_login DATETIME NULL,
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    verified_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL
);

INSERT INTO utilizadores (username, email, image, telefone, password, morada, dt_nascimento, dt_criacao, pronomes, is_admin, ultimo_login, is_verified, verified_at, created_at, updated_at) VALUES
('FabioK','fabio.vitoriano@icloud.com', 'assets/images/users/Fabio_icon.jpeg','+351967140012','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Praça de Antunes, 76, 1214-236 Vila Nova de Santo André','2008-03-02','2024-01-01','ele/dele',1,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('vulgo.arthur','arthurmellomattos@gmail.com', 'assets/images/users/Arthur_icon.png','+351911507683','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Alameda Melo, 119, 3461-205 Viseu','2008-03-10','2024-01-01','ele/dele',1,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('ricardo95','ricardo95@gmail.com', 'assets/images/users/ricardo.webp','+351922391890','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Av do Arboreto, 50, 0642-990 Setúbal','1971-04-19','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00');
('kevinThrone','Kevin.thrones@gmail.com','4','+351929518195','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Largo Rita Abreu, 32, 0138-963 Barreiro','1987-02-11','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Marinheirus','david.coelho4@gmail.com','5','+351915279273','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Avenida Eva Costa, S/N, 3879-216 Porto','2002-01-31','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Elli','emozinho@gmail.com','6','+351912114123','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Alameda do Preto, 68, 1022-144 Barcelos','2004-05-02','2024-01-01','elu/delu',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Neocaridina','aquarios@gmail.com','7','+351920954523','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Praça Esteves, 55, 1907-642 Silves','2007-01-17','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Scott Pilgrim','scott.pilgrim@icloud.com','8','+351961542229','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Alameda Garcia de Orta ao Parque das Nações, 7, 7521-734 Mealhada','1999-07-30','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('afonso21','afonso21@gmail.com','9','+351917044566','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Avenida Marques, 597, 8475-049 Caniço','1973-12-01','2024-01-01','elu/delu',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Michael.Jhon','michael.jacson1@hotmail.com','10','+351917984566','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Avenida Marques, 597, 8475-049 Caniço','1963-12-01','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00');

INSERT INTO utilizadores (username, email, image, telefone, password, morada, dt_nascimento, dt_criacao, pronomes, is_admin, ultimo_login, is_verified, verified_at, created_at, updated_at) VALUES
('NunosAgitar','nuninho@icloud.com','11','+351918531317','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','R. Maestro Ivo Cruz, 82, 8078-371 Alcobaça','2006-01-22','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('mpinheiro','martim.pinehiro@hotmail.com','12','+351915603474','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Praça Carvalho, S/N, 4586-648 Vizela','1960-09-07','2024-01-01',NULL,0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Cadu Freire','CaduFreire@gmail.com','13','+351926433009','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Praça Tavares, S/N, 8908-932 Quarteira','2006-03-09','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Johnny vito','joao.vitoriano@consexto.com','14','+351969227803','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Av do Mirante, 39, 2738-696 Vila Franca de Xira','1983-12-09','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('ysimoes','ysimoes@icloud.com','15','+351923353733','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Avenida de Cunha, 550, 4247-998 Porto','1990-11-15','2024-01-01','elu/delu',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('carolis','nailedbycarolis@icloud.com','16','+351965152894','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Alameda do Borratém, 5, 3587-206 Tarouca','2009-04-28','2024-01-01','ela/dela',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Gengar','gengardasilva@gmail.com','17','+351916437666','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Alameda do Campo Alegre, 348, 4263-400 Barreiro','1994-03-14','2024-01-01','elu/delu',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('amaralmaria','maralmaria@hotmail.com','18','+351969797144','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Av das Sereias, 10, 5983-288 Ponta Delgada','1979-04-23','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('JPEGMAFIA','ppeggy@gmail.com','19','+351914180238','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Alameda de Sá, 40, 6483-066 Rebordosa','1991-03-19','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Correia','correia.jonas@icloud.com','20','+351925787176','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Praça de Cardoso, 69, 7914-450 Trofa','1997-05-22','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00');

INSERT INTO utilizadores (username, email, image, telefone, password, morada, dt_nascimento, dt_criacao, pronomes, is_admin, ultimo_login, is_verified, verified_at, created_at, updated_at) VALUES
('12345','12345@gmail.com','23','+351912345678','$2y$10$SJa0ptPX/quBesjk8mgv9.6LO0qaF9BZUKUOzI776kwK5t.zGN5jy','Rua Exemplo, 123, 1234-567 Cidade','1990-01-01','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00');