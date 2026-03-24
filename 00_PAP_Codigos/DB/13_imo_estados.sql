USE imo_system;

DROP TABLE IF EXISTS estados;

CREATE TABLE estados (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_estado VARCHAR(100) NOT NULL,
    cor_estado CHAR(3) NOT NULL
);

INSERT INTO estados(nome_estado ,cor_estado) VALUES
('Encomenda Cancelada', 'R'), -- Red
('Encomenda Enviada', 'B'), -- Blue
('Encomenda Entregue', 'G'), -- Green
('Encomenda em Transferência', 'Y'), -- Yellow
('Pedido por pagar', 'Y'), -- Yellow
('Conta Apagada', 'R'), -- Red
('Conta Banida', 'DR'), -- DarkRed
('Conta Suspensa', 'Y'), -- Yellow
('Conta Ativa', 'G'); -- Green

