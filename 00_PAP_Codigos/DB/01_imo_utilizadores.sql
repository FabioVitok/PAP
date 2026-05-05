USE imo_system;

DROP TABLE IF EXISTS utilizadores;

CREATE TABLE utilizadores (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    imageId VARCHAR(255),
    telefone VARCHAR(14) UNIQUE,
    password VARCHAR(255) NOT NULL,
    morada VARCHAR(255) NOT NULL,
    dt_nascimento DATE NOT NULL,
    pronomes VARCHAR(20)
);

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('FabioK','fabio.vitoriano@icloud.com','+351967140012','+V4EWil**5','Praça de Antunes, 76, 1214-236 Vila Nova de Santo André','2008-03-02','ele/dele'),
('vulgo.arthur','arthurmellomattos@gmail.com','+351911507683','cFP!f3YfrQ','Alameda Melo, 119, 3461-205 Viseu','2008-03-10','ele/dele'),
('ricardo95','ricardo95@gmail.com','+351922391890','Avv9PLCp$5','Av do Arboreto, 50, 0642-990 Setúbal','1971-04-19','ele/dele'),
('kevinThrone','Kevin.thrones@gmail.com','+351929518195','K^6YyFUjl(','Largo Rita Abreu, 32, 0138-963 Barreiro','1987-02-11','ele/dele'),
('Marinheirus','david.coelho4@gmail.com','+351915279273','ZSDJn0Wg*y','Avenida Eva Costa, S/N, 3879-216 Porto','2002-01-31','ele/dele'),
('Elli','emozinho@gmail.com','+351912114123','0+Nzkei4%2','Alameda do Preto, 68, 1022-144 Barcelos','2004-05-02','elu/delu'),
('Neocaridina','aquarios@gmail.com','+351920954523','(%a*B3Qp!%','Praça Esteves, 55, 1907-642 Silves','2007-01-17','ele/dele'),
('Scott Pilgrim','scott.pilgrim@icloud.com','+351961542229','R*d9yhunTQ','Alameda Garcia de Orta ao Parque das Nações, 7, 7521-734 Mealhada','1999-07-30','ele/dele'),
('afonso21','afonso21@example.com','+351917044566','Al2We2oAQ@','Avenida Marques, 597, 8475-049 Caniço','1973-12-01','elu/delu');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('NunosAgitar','nuninho@icloud.com','+351918531317','4KX32t#7$&','R. Maestro Ivo Cruz, 82, 8078-371 Alcobaça','2006-01-22','ele/dele'),
('mpinheiro','martim.pinehiro@hotmail.com','+351915603474','i*RN89NvUO','Praça Carvalho, S/N, 4586-648 Vizela','1960-09-07',NULL),
('Cadu Freire','CaduFreire@gmail.com','+351926433009','59D0a*x8_O','Praça Tavares, S/N, 8908-932 Quarteira','2006-03-09','ele/dele'),
('Johnny vito','joao.vitoriano@consexto.com','+351969227803','!9C1Di!sLT','Av do Mirante, 39, 2738-696 Vila Franca de Xira','1983-12-09','ele/dele'),
('ysimoes','ysimoes@icloud.com','+351923353733','$0nTTheCtU','Avenida de Cunha, 550, 4247-998 Porto','1990-11-15','elu/delu'),
('carolis','nailedbycarolis@icloud.com','+351965152894','8OO8N1Zf1_','Alameda do Borratém, 5, 3587-206 Tarouca','2009-04-28','ela/dela'),
('Gengar','gengardasilva@gmail.com','+351916437666','+E9^EyYkl4','Alameda do Campo Alegre, 348, 4263-400 Barreiro','1994-03-14','elu/delu'),
('amaralmaria','maralmaria@hotmail.com','+351969797144','a@ST*9Wwn_','Av das Sereias, 10, 5983-288 Ponta Delgada','1979-04-23','ele/dele'),
('JPEGMAFIA','ppeggy@gmail.com','+351914180238','(RbbOcdp3k','Alameda de Sá, 40, 6483-066 Rebordosa','1991-03-19','ele/dele'),
('Correia','correia.jonas@icloud.com','+351925787176','D&b7BJyePa','Praça de Cardoso, 69, 7914-450 Trofa','1997-05-22','ele/dele');
