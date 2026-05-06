<?php

// Inicia a sessão para aceder aos dados do utilizador autenticado
session_start();

// Importa a ligação à base de dados (PDO)
require_once 'db.php';

// Define o tipo de resposta como JSON com codificação UTF-8
header('Content-Type: application/json; charset=utf-8');

// 1. Verificar se o utilizador fez login

if(!isset($_SESSION['utilizador'])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Acesso não autorizado.'
        ]);
    exit;
}

// 2. Verificar se o pedido é post

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false, 
        'message' => 'Método inválido.'
        ]);
    exit;
}

// 3. Receber os dados do formulário

$id = trim($_POST['id'] ?? '');
$nome = trim($_POST['nome'] ?? '');
$nif = trim($_POST['nif'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$morada = trim($_POST['morada'] ?? '');

// 4. Validar campos obrigatórios

if($id === '' || $nome === '' || $nif === '') {
    
    echo json_encode([
        'success' => false, 
        'message' => 'ID, Nome e NIF são obrigatórios.'
        ]);

    exit;
}

// 5. Atualizar o cliente na base de dados

try {
    // SQL de atualização
    $sql = "UPDATE clientes 
        SET nome = ?, nif = ?, email = ?, telefone = ?, morada = ? 
        WHERE id = ?";
    
    // Prepara a instrução SQL
    $stmt = $pdo->prepare($sql);

    // Executa a query com os valores recebidos
    $stmt->execute([
        $nome, 
        $nif, 
        $email, 
        $telefone, 
        $morada, 
        $id
    ]);

// 6. Verificar se o registo existia

    if($stmt->rowCount() > 0) {

        echo json_encode([
            'success' => true, 
            'message' => 'Cliente atualizado com sucesso.'
            ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Cliente não encontrado ou sem alterações.'
            ]);
        }

    } catch(PDOException $e) {

// 7. Devolver Erro

        echo json_encode([
            'success' => false, 
            'message' => 'Erro ao atualizar cliente: ' . $e->getMessage()
        ]);
    }