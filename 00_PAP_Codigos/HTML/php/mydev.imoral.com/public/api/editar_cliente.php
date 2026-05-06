<?php

// Inicia a sessão para aceder aos dados do utilizador autenticado
session_start();

// Importa a ligação à base de dados (PDO)
require_once 'db.php';

// Define o tipo de resposta como JSON com codificação UTF-8

// 1. Verificar se o utilizador fez login

if(!isset($_SESSION['utilizador'])) {
    echo json encode([
        'success' => false, 
        'message' => 'Acesso não autorizado.'
        ]);
    exit;
}