USE imo_system;

DROP TABLE IF EXISTS utilizadores;

CREATE TABLE utilizadores (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    image_id INT(11),
    telefone VARCHAR(14) UNIQUE,
    password VARCHAR(255) NOT NULL,
    morada VARCHAR(255) NOT NULL DEFAULT '',
    dt_nascimento DATE NULL,
    dt_criacao DATETIME NOT NULL,
    pronomes VARCHAR(20),
    is_admin BOOLEAN NOT NULL,
    ultimo_login DATETIME NULL,
    is_verified TINYINT(1) NOT NULL DEFAULT 0,
    verified_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL
);

INSERT INTO utilizadores (username, email, image_id, telefone, password, morada, dt_nascimento, dt_criacao, pronomes, is_admin, ultimo_login, is_verified, verified_at, created_at, updated_at) VALUES
('FabioK','fabio.vitoriano@icloud.com',1,'+351967140012','+V4EWil**5','Praça de Antunes, 76, 1214-236 Vila Nova de Santo André','2008-03-02','2024-01-01','ele/dele',1,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('vulgo.arthur','arthurmellomattos@gmail.com',2,'+351911507683','cFP!f3YfrQ','Alameda Melo, 119, 3461-205 Viseu','2008-03-10','2024-01-01','ele/dele',1,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('ricardo95','ricardo95@gmail.com',3,'+351922391890','Avv9PLCp$5','Av do Arboreto, 50, 0642-990 Setúbal','1971-04-19','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('kevinThrone','Kevin.thrones@gmail.com',4,'+351929518195','K^6YyFUjl(','Largo Rita Abreu, 32, 0138-963 Barreiro','1987-02-11','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Marinheirus','david.coelho4@gmail.com',5,'+351915279273','ZSDJn0Wg*y','Avenida Eva Costa, S/N, 3879-216 Porto','2002-01-31','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Elli','emozinho@gmail.com',6,'+351912114123','0+Nzkei4%2','Alameda do Preto, 68, 1022-144 Barcelos','2004-05-02','2024-01-01','elu/delu',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Neocaridina','aquarios@gmail.com',7,'+351920954523','(%a*B3Qp!%','Praça Esteves, 55, 1907-642 Silves','2007-01-17','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Scott Pilgrim','scott.pilgrim@icloud.com',8,'+351961542229','R*d9yhunTQ','Alameda Garcia de Orta ao Parque das Nações, 7, 7521-734 Mealhada','1999-07-30','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('afonso21','afonso21@gmail.com',9,'+351917044566','Al2We2oAQ@','Avenida Marques, 597, 8475-049 Caniço','1973-12-01','2024-01-01','elu/delu',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Michael.Jhon','michael.jacson1@hotmail.com',10,'+351917984566','Al2We2oAQ@','Avenida Marques, 597, 8475-049 Caniço','1963-12-01','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00');

INSERT INTO utilizadores (username, email, image_id, telefone, password, morada, dt_nascimento, dt_criacao, pronomes, is_admin, ultimo_login, is_verified, verified_at, created_at, updated_at) VALUES
('NunosAgitar','nuninho@icloud.com',11,'+351918531317','4KX32t#7$&','R. Maestro Ivo Cruz, 82, 8078-371 Alcobaça','2006-01-22','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('mpinheiro','martim.pinehiro@hotmail.com',12,'+351915603474','i*RN89NvUO','Praça Carvalho, S/N, 4586-648 Vizela','1960-09-07','2024-01-01',NULL,0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Cadu Freire','CaduFreire@gmail.com',13,'+351926433009','59D0a*x8_O','Praça Tavares, S/N, 8908-932 Quarteira','2006-03-09','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Johnny vito','joao.vitoriano@consexto.com',14,'+351969227803','!9C1Di!sLT','Av do Mirante, 39, 2738-696 Vila Franca de Xira','1983-12-09','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('ysimoes','ysimoes@icloud.com',15,'+351923353733','$0nTTheCtU','Avenida de Cunha, 550, 4247-998 Porto','1990-11-15','2024-01-01','elu/delu',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('carolis','nailedbycarolis@icloud.com',16,'+351965152894','8OO8N1Zf1_','Alameda do Borratém, 5, 3587-206 Tarouca','2009-04-28','2024-01-01','ela/dela',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Gengar','gengardasilva@gmail.com',17,'+351916437666','+E9^EyYkl4','Alameda do Campo Alegre, 348, 4263-400 Barreiro','1994-03-14','2024-01-01','elu/delu',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('amaralmaria','maralmaria@hotmail.com',18,'+351969797144','a@ST*9Wwn_','Av das Sereias, 10, 5983-288 Ponta Delgada','1979-04-23','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('JPEGMAFIA','ppeggy@gmail.com',19,'+351914180238','(RbbOcdp3k','Alameda de Sá, 40, 6483-066 Rebordosa','1991-03-19','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00'),
('Correia','correia.jonas@icloud.com',20,'+351925787176','D&b7BJyePa','Praça de Cardoso, 69, 7914-450 Trofa','1997-05-22','2024-01-01','ele/dele',0,'2024-06-01 10:00:00',1,'2024-01-01 00:00:00','2024-01-01 00:00:00','2024-01-01 00:00:00');