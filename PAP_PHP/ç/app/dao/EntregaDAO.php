<?php

require_once __DIR__ . '/../models/Entrega.php';
require_once __DIR__ . '/../config/Database.php';

class EntregaDAO {

    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    private function rowToEntrega(array $row): Entrega {
        return new Entrega(
            id:             (int)$row['id'],
            id_pedido:      (int)$row['id_pedido'],
            morada_entrega: $row['morada_entrega'],
            metodo_envio:   $row['metodo_envio'],
            entregadora:    $row['entregadora'],
            peso:           (float)$row['peso'],
            created_at:     $row['created_at']
        );
    }
}
?>