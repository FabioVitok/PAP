USE imo_system;

DROP TABLE IF EXISTS estados;

CREATE TABLE estados (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_estado VARCHAR(100) NOT NULL,
    cor_estado CHAR(7) NOT NULL
);

INSERT INTO estados(nome_estado ,cor_estado) VALUES
-- Estados de encomenda
('Encomenda Cancelada', '#fc1c03'), -- Vermelho
('Encomenda Enviada', '#039dfc'), -- Azul
('Encomenda Entregue', '#03fc4a'), -- Verde
('Encomenda em Transferência', '#fce703'), -- Amarelo
('Pedido por pagar', '#ff7300'), -- Amarelo
('Encomenda a ser Preparada', '#fce703'), -- Amarelo
-- Estados de conta
('Conta Apagada', '#fc1c03'), -- Vermelho
('Conta Banida', '#ad0000'), -- Vermelho Escuro
('Conta Suspensa', '#fce703'), -- Amarelo
('Conta Ativa', '#03fc4a'), -- Verde
('Conta Inativa', '#ff8a0d'); -- Laranja

