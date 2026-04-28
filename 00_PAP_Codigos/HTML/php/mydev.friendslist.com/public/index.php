<?php
//IMPORTS
require "../app/controllers/WebController.php";
require "../app/controllers/AuthController.php";
require "../app/services/Mailer.php";
require __DIR__ . '/../vendor/autoload.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = str_replace("mydevpiratas.com/public", "", $uri);

$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/' || $uri === '/index' || $uri === '/home') {
  (new WebController())->index();

} else if ($uri === '/login' && $method === 'GET') {
  (new WebController())->login();
} else if ($uri === '/login' && $method === 'POST') {
  // Apanhar os dados do formulário

  //var_dump($email, $password);

  (new AuthController())->loginWeb();
} else if ($uri === '/about') {
  (new WebController())->about();
}

// Signup routes 
elseif($uri === '/signup' && $method === 'GET') {
  (new WebController())->signup();
} elseif ($uri === '/signup' && $method === 'POST') {
  try {
    (new AuthController())->signupWeb();
    echo "User registered successfully!";
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
}

elseif($uri === '/send-email/test' && $method === 'GET') {
  var_dump('/send-email/test');

  $html = file_get_contents(__DIR__ . '/views/emails/welcome.php');

  (new Mailer())->send(
    "37595@esjaloures.org",
    "Test Email",
    $html
  );
} else {
  http_response_code(404);
  echo "404 Not Found";
}