<?php
session_start();

// IMPORTS
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . "/../app/controllers/WebController.php";
require_once __DIR__ . "/../app/controllers/AuthController.php";
require_once __DIR__ . "/../app/controllers/UserController.php";
require_once __DIR__ . "/../app/controllers/ProductController.php";
require_once __DIR__ . "/../app/controllers/PostController.php";
require_once __DIR__ . "/../app/services/Mailer.php";
require_once __DIR__ . "/../app/mddleware/AuthMiddlewareWeb.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = str_replace("mydev.imoral.com/public", "", $uri);

$method = $_SERVER['REQUEST_METHOD'];

//var_dump($_SESSION);

if($uri === '/' || $uri === '/index' || $uri === '/home') {
    (new WebController())->index();
}

elseif($uri === '/pagina-privada' && $method === 'GET') {
    $isLogin = AuthMiddlewareWeb::isLogin();

    if(!$isLogin) {
        header("Location: /login");
        exit;
    } else {
        die("Aceder à página privada");
    }
}

elseif($uri === '/login' && $method === 'GET') {
    if(AuthMiddlewareWeb::isLogin()) {
        header("Location: /");
        exit;
    } else {
        (new WebController())->login();
    }
}

elseif($uri === '/login' && $method === 'POST') {
    (new AuthController())->loginWeb();
}

elseif($uri === '/logout' && $method === 'GET') {
    if(AuthMiddlewareWeb::isLogin()) {
        (new AuthController())->logoutWeb();
        exit;
    } else {
        header("Location: /");
        exit;
    }
}

elseif($uri === '/signup' && $method === 'GET') {
    (new WebController())->signup();
}

elseif($uri === '/signup' && $method === 'POST') {

    try {
        (new AuthController())->signupWeb();

    } catch (Exception $e) {

        var_dump($e);
        var_dump($e->getMessage());
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => $e->getMessage()
        ];
        header("Location: /signup");
        exit();
    }
    

}

elseif($uri === '/verify-email' && $method === 'GET') {
    // var_dump("Entrar na página de verificação de email");    
    (new AuthController())->verifyEmailForm();
}

elseif($uri === '/verify-email' && $method === 'POST') {
    try {
        (new AuthController())->verifyEmailSubmit();
    } catch (Exception $e) {
        var_dump($e);
        var_dump($e->getMessage());
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => $e->getMessage()
        ];
        header("Location: /verify-email");
        exit();
    }
}

elseif($uri === '/users' && $method === 'GET') {
    try{
        (new UserController())->getUsers();
    } catch (Exception $e) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => $e->getMessage()
        ];
        header("Location: /users");
        exit();
    }
}

elseif(preg_match('#^/users\/(\d+)$#', $uri, $m) && $method === 'GET') {
    (new UserController())->profile($m[1]);
}

elseif(preg_match('#^/users\/(\d+)/update$#', $uri, $m) && $method === 'POST') {
    try{
        (new UserController())->update($m[1]);

        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Perfil atualizado com sucesso!'
        ];
        header("Location: /users/{$m[1]}");
        exit();
    } catch (Exception $e) {
        var_dump($e);
        var_dump($e->getMessage());
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => $e->getMessage()
        ];
        header("Location: /users/{$m[1]}");
        exit();
    }
}

elseif($uri === '/admin/users/create' && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem criar utilizadores.");
    }
    try {
        (new AuthController())->adminCreateUser();
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Utilizador criado com sucesso.'];
    } catch (Exception $e) {
        $_SESSION['toast'] = ['type' => 'error', 'message' => $e->getMessage()];
    }
    header("Location: /dashboard");
    exit;
}

elseif(preg_match('#^/users\/(\d+)/activate$#', $uri, $m) && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem ativar utilizadores.");
    } try {
        (new UserController())->activateUser($m[1]);
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Utilizador ativado com sucesso.'];
    } catch (Exception $e) {
        $_SESSION['toast'] = ['type' => 'error', 'message' => $e->getMessage()];
    }
}

elseif(preg_match('#^/users\/(\d+)/suspend$#', $uri, $m) && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem suspender utilizadores.");
    } try {
        (new UserController())->suspendUser($m[1]);
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Utilizador suspenso com sucesso.'];
    } catch (Exception $e) {
        $_SESSION['toast'] = ['type' => 'error', 'message' => $e->getMessage()];
    }
}

elseif(preg_match('#^/users\/(\d+)/delete$#', $uri, $m) && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem eliminar utilizadores.");
    } try {
        (new UserController())->deleteUser($m[1]);
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Utilizador eliminado com sucesso.'];
    } catch (Exception $e) {
        $_SESSION['toast'] = ['type' => 'error', 'message' => $e->getMessage()];
    }
}

elseif(preg_match('#^/users\/(\d+)/unban$#', $uri, $m) && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem desbanir utilizadores.");
    }
    try {
        (new UserController())->unbanUser($m[1]);
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Utilizador desbanido com sucesso.'];
    } catch (Exception $e) {
        $_SESSION['toast'] = ['type' => 'error', 'message' => $e->getMessage()];
    }
}

elseif($uri === '/produtospai/create' && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem criar produtos pai.");
    }
    (new ProductController())->storePai($_POST);
}

elseif(preg_match('#^/productspai\/(\d+)/update$#', $uri, $m) && $method === 'POST') {
    try{
        (new ProductController())->updatePai($m[1]);
        $_SESSION['toast'] = 
        ['type' => 'success',
         'message' => 'Produto atualizado com sucesso!'];
    } catch (Exception $e) {
        $_SESSION['toast'] = 
        ['type' => 'error',
        'message' => $e->getMessage()];
    }
}

elseif($uri === '/products/create' && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem criar produtos.");
    }
    (new ProductController())->store($_POST);
}

elseif(preg_match('#^/products\/(\d+)/update$#', $uri, $m) && $method === 'POST') {
    try{
        (new ProductController())->update($m[1]);

        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Produto atualizado com sucesso!'
        ];
        header("Location: /products/{$m[1]}");
        exit();
    } catch (Exception $e) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => $e->getMessage()
        ];
        header("Location: /products/{$m[1]}");
        exit();
    }
}

elseif(preg_match('#^/products\/(\d+)/delete$#', $uri, $m) && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem eliminar produtos.");
    }
    try{
        (new ProductController())->delete($m[1]);
        Utils::jsonResponse(['success' => true]);
    } catch (Exception $e) {
        Utils::jsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
    }
}

elseif($uri === '/posts/create' && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem criar posts.");
    }
    (new PostController())->store($_POST);
}

elseif(preg_match('#^/posts/(\d+)/update$#', $uri, $m) && $method === 'POST') {
    try {
        (new PostController())->update((int)$m[1]);

        $_SESSION['toast'] = [
            'type'    => 'success',
            'message' => 'Post atualizado com sucesso!'
        ];
        header("Location: /admin");
        exit();
    } catch (Exception $e) {
        $_SESSION['toast'] = [
            'type'    => 'error',
            'message' => $e->getMessage()
        ];
        exit();
    }
}

elseif(preg_match('#^/posts/(\d+)/delete$#', $uri, $m) && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem eliminar posts.");
    }
    try {
        (new PostController())->delete((int)$m[1]);
        Utils::jsonResponse(['success' => true]);
    } catch (Exception $e) {
        Utils::jsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
    }
}

elseif(preg_match('#^/posts/(\d+)/restore$#', $uri, $m) && $method === 'POST') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        throw new Exception("Acesso negado. Apenas administradores podem restaurar posts.");
    }
    try {
        (new PostController())->restore((int)$m[1]);
        Utils::jsonResponse(['success' => true]);
    } catch (Exception $e) {
        Utils::jsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
    }
}

elseif($uri === '/dashboard' && $method === 'GET') {
    if(!AuthMiddlewareWeb::isAdmin()) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Acesso negado. Apenas administradores podem acessar o dashboard.'
        ];
        header("Location: /home");
        exit;
    } else {
        (new WebController())->dashboard();
    }
}

// Rota das páginas de erro
elseif($uri === '/bad-request' && $method === 'GET') {
    (new WebController())->badRequest();
}

else {
    echo "404 - Página não encontrada.";
}