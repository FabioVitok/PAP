<?php
session_start();
require_once "db.php";

header("Content-Type: application/json; charset=utf-8");

// 1. Verificar sessão
if (!isset($_SESSION["utilizador"])) {
    echo json_encode([
        "success" => false,
        "message" => "Acesso não autorizado."
    ]);
    exit;
}

// 2. Consultar clientes
try {
    $sql = "SELECT id, nome, nif, email, telefone, morada
            FROM clientes
            ORDER BY id DESC";

    $stmt = $pdo->query($sql);
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Resposta de sucesso
    echo json_encode([
        "success" => true,
        "clientes" => $clientes
    ]);

} catch (PDOException $e) {

    // 4. Resposta de erro
    echo json_encode([
        "success" => false,
        "message" => "Erro ao listar clientes: " . $e->getMessage()
    ]);
}