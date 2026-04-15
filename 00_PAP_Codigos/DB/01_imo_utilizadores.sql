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
('ricardo95','frederico24@example.org','+351922391890','Avv9PLCp$5','Av do Arboreto, 50, 0642-990 Setúbal','1971-04-19','elu/delu'),
('kevim49','leonorreis@example.net','+351929518195','K^6YyFUjl(','Largo Rita Abreu, 32, 0138-963 Barreiro','1997-02-11','ele/dele'),
('eduardo17','diego24@example.net','+351915279273','ZSDJn0Wg*y','Avenida Eva Costa, S/N, 3879-216 Porto','1986-01-31','ele/dele'),
('carlota96','vicentenelson@example.net','+351912114123','0+Nzkei4%2','Alameda do Preto, 68, 1022-144 Barcelos','1968-05-02','ele/dele'),
('valentina11','magalhaesnoah@example.net','+351920954523','(%a*B3Qp!%','Praça Esteves, 55, 1907-642 Silves','2007-01-17','ele/dele'),
('nogueirairis','violetarocha@example.org','+351961542229','R*d9yhunTQ','Alameda Garcia de Orta ao Parque das Nações, 7, 7521-734 Mealhada','1971-07-30','ela/dela'),
('baptistagaspar','afonso21@example.com','+351917044566','Al2We2oAQ@','Avenida Marques, 597, 8475-049 Caniço','1973-12-01','elu/delu'),
('carneironadia','ericatavares@example.org','+351936881899','+V4EWil**5','Praça de Antunes, 76, 1214-236 Vila Nova de Santo André','1974-02-08','ela/dela'),
('lucia21','ericalima@example.net','+351911507683','cFP!f3YfrQ','Alameda Melo, 119, 3461-205 Viseu','1971-02-07','ele/dele');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('melojose','manuelneto@example.org','+351918531317','4KX32t#7$&','R. Maestro Ivo Cruz, 82, 8078-371 Alcobaça','1983-01-22','ele/dele'),
('mpinheiro','erica94@example.com','+351915603474','i*RN89NvUO','Praça Carvalho, S/N, 4586-648 Vizela','1983-09-07','elu/delu'),
('nbarbosa','mateus61@example.net','+351926433009','59D0a*x8_O','Praça Tavares, S/N, 8908-932 Quarteira','1995-03-09','ela/dela'),
('xmota','ramospilar@example.com','+351969227803','!9C1Di!sLT','Av do Mirante, 39, 2738-696 Vila Franca de Xira','1982-10-27','ele/dele'),
('maria00','ysimoes@example.org','+351923353733','$0nTTheCtU','Avenida de Cunha, 550, 4247-998 Porto','1990-11-15','ele/dele'),
('caetana51','emiliamatos@example.org','+351965152894','8OO8N1Zf1_','Alameda do Borratém, 5, 3587-206 Tarouca','1975-04-28','ele/dele'),
('oliveirabryan','rui61@example.net','+351916437666','+E9^EyYkl4','Alameda do Campo Alegre, 348, 4263-400 Barreiro','1994-03-14','elu/delu'),
('amaralmaria','silvavioleta@example.com','+351969797144','a@ST*9Wwn_','Av das Sereias, 10, 5983-288 Ponta Delgada','1979-04-23','ele/dele'),
('rmendes','paivawilliam@example.net','+351914180238','(RbbOcdp3k','Alameda de Sá, 40, 6483-066 Rebordosa','1997-03-19','ela/dela'),
('qcorreia','matiasluciana@example.org','+351925787176','D&b7BJyePa','Praça de Cardoso, 69, 7914-450 Trofa','1997-05-22','elu/delu');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('guerreironaiara','barbaraesteves@example.org','+351935406234','&wrZo3@Vr8','Avenida de Antunes, 51, 0144-007 Alverca do Ribatejo','1993-01-30','ele/dele'),
('guerreiroafonso','qvieira@example.org','+351914035808','6@7iWomL+s','Rua de Andrade, 21, 4824-110 Barreiro','1984-09-17','ele/dele'),
('hpinho','tferreira@example.net','+351962131164','LX4Pq^%JQ#','Av de Mota, 507, 9988-961 Portimão','1996-01-13','elu/delu'),
('carneiroluis','gomesnair@example.net','+351932439744','+DD^JK%q)1','Rua Cardeal Cerejeira, 5, 4913-233 Abrantes','1992-11-24','elu/delu'),
('wilsonsantos','leonorrodrigues@example.org','+351965404996','0UNBj)Ga(g','R. de Araújo, S/N, 0936-142 Vila Nova de Gaia','1984-12-26','ela/dela'),
('diego38','leonardomiranda@example.com','+351914797733','O5ooV^d!%z','Travessa de Pires, S/N, 5925-138 Anadia','1968-02-14','ela/dela'),
('bnogueira','ramoshugo@example.net','+351921187193','Qf0!aZod#_','Rua de Marques, 32, 2068-342 São Salvador de Lordelo','1972-11-14','ele/dele'),
('leandro26','iaramorais@example.org','+351967969342','%a9Bg0cUau','Praça de Loureiro, 231, 8898-856 Trofa','1994-10-12','elu/delu'),
('valentina58','bsoares@example.org','+351965211644','V6LrVZXG_g','Avenida Amorim, 147, 6743-590 Marco de Canaveses','1988-07-28','ela/dela'),
('lucanogueira','soraiaanjos@example.org','+351927239149','!S4LXaxs9#','Travessa Gaspar Ribeiro, 75, 4725-235 Aveiro','1969-01-03','elu/delu');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('hmorais','marcosimoes@example.org','+351913507562','b5wtM!Ty&m','Praça Ribeiro, 6, 4690-639 Anadia','2004-12-14','elu/delu'),
('leticia38','lealbeatriz@example.org','+351916548465','QadlLtzN$5','Alameda Matias, 7, 5743-221 Loures','2003-05-15','ele/dele'),
('cunhajessica','macedopilar@example.org','+351920860219','j_R1#Kjf)@','Praça Henrique Macedo, 52, 6903-136 Amadora','1969-09-02','elu/delu'),
('svalente','coelhoedgar@example.net','+351912195471','a!k8RgnbRI','Alameda Brian Batista, 66, 0270-855 Almada','1978-09-08','ela/dela'),
('hugomota','lmonteiro@example.net','+351922687968','RHtEG_(g+0','Avenida Ramos, 57, 1114-260 São Mamede de Infesta','1990-08-29','elu/delu'),
('fabio18','macedomarcio@example.org','+351962074846','%Z#F%C!hR5','Travessa da Companhia, 66, 9985-850 Sacavém','1989-05-05','elu/delu'),
('henriquesmiriam','alvessimao@example.com','+351924604562','*4AkT*gj$E','Largo Antunes, 355, 9027-235 Macedo de Cavaleiros','1977-02-07','ele/dele'),
('qfaria','vieirabernardo@example.org','+351931884231',')sVzsNMnK6','Praça Bárbara Vaz, 3, 6668-731 Esmoriz','1990-03-10','ela/dela'),
('imachado','luca72@example.org','+351964068069','*W*Y7IFeR!','Av Gonçalo Magalhães, 72, 0879-818 Fátima','1984-02-19','ele/dele'),
('valentimmatos','andrenascimento@example.com','+351935081829','#H64NnyKn(','Travessa de Paiva, S/N, 3356-650 Cantanhede','1992-01-03','ele/dele');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('marianatorres','petrateixeira@example.org','+351911652524','_0zAnQmO^Y','Avenida de Carvalho, 609, 2174-107 Vila Nova de Foz Côa','1965-09-27','ela/dela'),
('edgarleal','irinalopes@example.net','+351929490577','iIVo4Ew@n)','Praça do Cerco do Porto, 32, 5217-857 Vila Real','1998-09-14','elu/delu'),
('violeta18','vmagalhaes@example.com','+351910701846','#nVSyOuqo2','Avenida Yasmin Ribeiro, 9, 7753-136 Lagoa','1966-02-19','ele/dele'),
('hmatias','freitasnair@example.org','+351927490745','4(u6ZBeE1j','R. Soares, S/N, 7051-881 Lixa','1977-03-13','elu/delu'),
('smatias','luisa61@example.org','+351969641075','_5%XScLy(f','Travessa Roentgen, 11, 0103-524 Sabugal','1976-09-16','ele/dele'),
('gsantos','tiagonascimento@example.net','+351927414047','45WqE9_W*u','Alameda Roentgen, 36, 7985-528 São Salvador de Lordelo','1987-05-13','ela/dela'),
('moreiraana','eduardomoura@example.net','+351962202953','7a#5ySYb_5','Largo Francisca Santos, 8, 0528-945 Matosinhos','1997-03-07','ele/dele'),
('bneto','salvador64@example.com','+351964296411','ZM2$XMHkO_','Praça do Dr. Manuel Laranjeira, 6, 6281-054 Loures','2004-02-26','ele/dele'),
('davidalmeida','raquel21@example.com','+351966807366','&P&)OUHki4','R. Abreu, 1, 1969-397 Vila Nova de Gaia','1981-12-15','elu/delu'),
('freitasnair','daniel23@example.org','+351961635882','441UVT0d*R','Largo de Borges, 63, 2680-053 Ribeira Grande','2004-08-12','ela/dela');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('drocha','luismoura@example.com','+351919085707','%ISm57Rs1J','Alameda de Nascimento, 3, 6906-412 Praia da Vitória','2006-03-21','ela/dela'),
('mariomiranda','dsousa@example.org','+351935009020','w6MygePw+c','Avenida Fabiana Brito, 2, 2548-229 Matosinhos','1997-07-21','ele/dele'),
('drodrigues','mateuspinho@example.com','+351919914565','K8lSYWyo_@','Avenida de Esteves, 11, 2596-328 Pinhel','1972-08-16','ela/dela'),
('tiago18','wilsonmelo@example.net','+351937667239','2(JpmOIY$M','Travessa Pinho, 64, 4032-727 Amora','2005-09-12','ela/dela'),
('lorena45','efreitas@example.com','+351917496991','%L6+CGqu9*','Rua Tavares, 256, 8700-424 Tomar','1993-11-13','elu/delu'),
('limabeatriz','mariafernandes@example.net','+351929738356','x^5)5DzI#s','Travessa Ferreira, 935, 8426-412 Rio Tinto','2007-05-22','ele/dele'),
('denisbatista','lealbenjamim@example.com','+351927920717','e85$ChTV(5','Rua de Soares, 84, 0068-601 Odivelas','1999-09-29','elu/delu'),
('emilia24','mendeserica@example.org','+351926642733','2$4VXQ#__x','R. de Freitas, 34, 0005-988 Amadora','1985-04-17','elu/delu'),
('simao06','simaofonseca@example.org','+351925589064','iu0HR^f5+$','Travessa António Dias Lourenço, 6, 5961-794 Santa Cruz','1989-10-05','elu/delu'),
('nuno52','igor15@example.net','+351922514047','H_4PSbhR%_','Avenida de Gonçalves, 46, 8509-386 Alcobaça','1965-03-20','elu/delu');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('sergiojesus','dmacedo@example.com','+351935737721','*4YQo#8pU6','Avenida Carneiro, 262, 2397-214 Mealhada','1966-08-30','ela/dela'),
('nicolecoelho','rcorreia@example.org','+351919263880',')!Y8y)3ez7','Av Amorim, 6, 5071-658 Oliveira de Azeméis','1999-02-23','ela/dela'),
('lorenabranco','amaralcaetana@example.com','+351938797691','^pUMSt6Kq1','Alameda Domingues, 42, 7510-786 Maia','1974-03-26','elu/delu'),
('loureirogoncalo','angela49@example.org','+351963654529','^8fZlUHr4E','Praça Francisco Castro, 618, 8098-411 Gouveia','1972-12-01','ela/dela'),
('beatriz18','angelo19@example.com','+351930708967','#I2cKpfSy%','Avenida de Mendes, 29, 6350-713 Praia da Vitória','1991-10-28','ele/dele'),
('teresa88','isabelasantos@example.com','+351926993453',')&2J%sw76)','Largo Leandro Assunção, S/N, 1464-182 Santa Maria da Feira','2001-05-30','elu/delu'),
('flima','hjesus@example.org','+351968815927','+@3GCYmyh5','R. Erika Garcia, 99, 3413-209 Lagoa','1972-06-14','ela/dela'),
('mendesnaiara','qcunha@example.net','+351925974699','6HZ5Wdzq_9','Av Carolina Reis, 86, 3654-306 Paços de Ferreira','1980-05-12','ela/dela'),
('ribeirocristiano','cristiano88@example.org','+351923813871','^&+NJql8!6','Praça Sousa, 17, 1718-465 Ílhavo','1987-08-16','ele/dele'),
('vieirajoao','emalopes@example.org','+351937051011','C+^0XkIiy&','Praça Neto, 58, 8659-800 Tarouca','1972-04-17','ele/dele');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('lourencocarlos','ema26@example.org','+351910810435','7^@OUgpw#1','Alameda Luana Carneiro, 14, 7303-689 Lagoa','1976-11-24','ele/dele'),
('jpinheiro','catarina82@example.org','+351927460798','&C@B7nChYT','Alameda de Ramos, 40, 3644-070 Torres Novas','1986-09-28','ela/dela'),
('arturbatista','cmoreira@example.com','+351915489510','I95Uni^3+!','Largo Carneiro, 90, 1978-144 Gondomar','1992-04-09','elu/delu'),
('umatias','meloisaac@example.com','+351969066506','(uMX0UfZGw','R. dos Capitães de Abril, 57, 1112-371 Beja','1981-11-28','ele/dele'),
('melokyara','pnascimento@example.org','+351961334978','7&q3lTDm)c','Alameda Carvalho, 5, 3421-429 Gandra','2003-10-22','elu/delu'),
('enzogomes','jrocha@example.org','+351919012104','n8^Odug&+6','R. de Estêvão Vasconcelos, 165, 2913-438 Lisboa','1974-08-01','elu/delu'),
('mia67','isaaccoelho@example.org','+351924735779','(M0CHKUl37','Rua de Melo, S/N, 2251-333 Seixal','2003-08-18','ele/dele'),
('leitesergio','magalhaeseva@example.org','+351961689636','22v*)bAR*s','Travessa de Arnaldo Gama, S/N, 5167-236 Covilhã','2003-09-06','ela/dela'),
('isaac07','pachecofernando@example.net','+351963141155','Y0c@Oy3f@I','R. das Conchas, 43, 7873-455 Vila Nova de Santo André','1984-01-18','ela/dela'),
('julianamiranda','mfaria@example.org','+351925708576','!7DFfZn1w2','Praça de Pinto, 28, 5069-908 Abrantes','1993-12-18','ele/dele');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('eneves','npires@example.com','+351963291635','Y)7_9X9pbb','Travessa Amaral, 89, 6419-712 Vila Nova de Santo André','1990-03-22','elu/delu'),
('costavictoria','nvaz@example.com','+351920232422','_xONVnw(n6','Travessa das Conchas, 85, 7358-454 Covilhã','1973-04-28','elu/delu'),
('uazevedo','henriquecardoso@example.com','+351968963838','VRYA&8YkW^','Rua Fonseca, 67, 5187-804 Horta','1986-09-10','ela/dela'),
('santiagoneto','pmartins@example.org','+351918193627','v9mVGwyP*#','Alameda Esteves, 914, 7268-304 Cartaxo','1994-05-02','ela/dela'),
('bmoreira','hgarcia@example.net','+351913646338','#5Vo@Swz&8','R. Constança Torres, S/N, 5991-838 Ribeira Grande','1972-06-10','elu/delu'),
('franciscoantunes','aamorim@example.net','+351937592252','L%Z4#JZ2Pj','R. Egito Gonçalves, 3, 9438-476 Estremoz','1989-09-11','ela/dela'),
('fpaiva','luca76@example.net','+351936162556','w&1M5TprrX','R. Valente, 931, 2818-276 Lisboa','1971-01-10','ele/dele'),
('antunescatarina','vieiramarco@example.org','+351965945534','VoT8t(Ac_k','Alameda de Cardoso, 4, 6523-022 Angra do Heroísmo','1993-05-26','ele/dele'),
('sandro79','henrique04@example.net','+351913552900','#OE7F$st_6','Travessa de Abreu, 77, 1583-115 Vila Nova de Foz Côa','2002-12-23','elu/delu'),
('pgomes','lucas60@example.com','+351930309035','(7+MsRG7Wb','Alameda das Antas, 18, 4433-559 Esposende','2001-04-01','ela/dela'),
('isabelagomes','valentim86@example.com','+351935817453',')w9Sz8rk56','Rua Rui Esteves, 5, 8157-380 Paços de Ferreira','1981-09-14','elu/delu');

INSERT INTO utilizadores (username, email, telefone, password, morada, dt_nascimento, pronomes) VALUES
('rafaeladomingues','dinis45@example.org','+351926407654','&8NNB_Mw_3','Avenida de Monteiro, 72, 1267-439 Gouveia','1994-10-05','elu/delu'),
('madalenasantos','fbarros@example.com','+351966232086','2N@(U_RW$z','Praça Tavares, S/N, 7512-158 Ermesinde','1986-02-28','ela/dela'),
('diego41','qgoncalves@example.com','+351965518046','*WHQQY+z2t','Praça Jesus, 51, 6739-910 Ílhavo','1978-07-05','ele/dele'),
('icardoso','bruno26@example.com','+351931732160','glS0!KIo_O','R. de Pinho, 46, 8348-562 Porto Santo','1989-08-01','ela/dela'),
('loureiromaria','luca60@example.net','+351935459032','*7kAMbeP6S','R. António Ferreira, 601, 8047-674 Lixa','1971-09-08','ela/dela'),
('naiaracarvalho','kevimcardoso@example.com','+351934032932','h#7P!uDbf^','R. Eduardo Gonçalves, 6, 4467-003 Seia','1994-03-31','ela/dela'),
('dnunes','helenamoura@example.org','+351928712503','@u7zyQiUo!','Rua Benedita Campos, 16, 5681-147 Odivelas','1999-05-10','ele/dele'),
('kfaria','marianafernandes@example.org','+351934951264','%hiy0vW+p5','Praça Rodrigues, S/N, 1036-276 Odivelas','1975-04-29','ela/dela'),
('alvaro64','francisca50@example.com','+351933267657','+_3S_z(@*U','Travessa de Fonseca, 34, 2629-961 Portimão','2004-09-12','ele/dele'),
('lucas39','mafalda50@example.net','+351963119577','*e8KWqc)zh','R. Kelly Matias, 41, 8738-870 Olhão','1995-10-18','elu/delu');
