<?php

require_once __DIR__ . '/../models/Pagamento.php';
require_once __DIR__ . '/../config/Database.php';

class PagamentoDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToPagamento(array $row): Pagamento {
        return new Pagamento(
            id:                 (int)$row['id'],
            id_utilizador:      (int)$row['id_utilizador'],
            id_pedido:          (int)$row['id_pedido'],
            metodo_pagamento:   $row['metodo_pagamento'],
            valor:              (float)$row['valor'],
            created_at:         $row['created_at']
        );
    }
}
?>