<?php
session_start();
//IMPORTS
require "../app/controllers/WebController.php";
require "../app/controllers/AuthController.php";
require "../app/services/Mailer.php";
require __DIR__ . '/../vendor/autoload.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = str_replace("mydev.imoral.com/public", "", $uri);

$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/' || $uri === '/index' || $uri === '/home') {
  (new WebController())->index();

} else if ($uri === '/login' && $method === 'GET') {
  (new WebController())->login();
} else if ($uri === '/login' && $method === 'POST') {
  (new AuthController())->loginWeb();

} elseif ($uri === '/signup' && $method === 'GET') {
  (new WebController())->signup();
} elseif ($uri === '/signup' && $method === 'POST') {
  try {
    (new AuthController())->signupWeb();
  } catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    // Redirecionar de volta para a página de signup GET
    header("Location: /signup");
    exit();
  }
  (new AuthController())->verifyEmailForm($token);

} else if ($uri === '/about') {
  (new WebController())->about();

} elseif ($uri === '/send-email/test' && $method === 'GET') {
  $html = file_get_contents(__DIR__ . '/views/emails/welcome.php');
  (new Mailer())->send(
    "37595@esjaloures.org",
    "Test Email",
    $html
  );

} elseif ($uri === "/verify-email" && $method === "GET") {
  $token = $_GET['token'] ?? '';

  (new AuthController())->verifyEmailForm($token);
}

//Erros pages
elseif ($uri === '/bad-request') {
  (new WebController())->badRequest();

} else {
  http_response_code(404);
  echo "404 Not Found";
}