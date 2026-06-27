<?php 
require_once __DIR__.'/../../vendor/autoload.php';

require_once __DIR__.'/../../app/utils/Utils.php';
require_once __DIR__.'/../../app/controllers/AuthController.php';
require_once __DIR__.'/../../app/controllers/UserController.php';
require_once __DIR__ . '/../../app/controllers/ProductController.php';
require_once __DIR__ . '/../../app/controllers/CarrinhoController.php';
require_once __DIR__ . '/../../app/controllers/CarrinhoProdutosController.php';
//require_once __DIR__ . '/../../app/controllers/WishlistController.php';
require_once __DIR__ . '/../../app/controllers/WishlistProdutosController.php';
require_once __DIR__.'/../../app/controllers/PostController.php';
require_once __DIR__.'/../../app/controllers/ComentarioController.php';
require_once __DIR__ . '/../../app/controllers/PedidoProdutosController.php';
require_once __DIR__ .'/../../app/controllers/PostController.php';
require_once __DIR__.'/../../app/mddleware/AuthMiddlewareApi.php';



use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

header('Content-Type: application/json; charset=UTF-8');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = str_replace('/api', '', $uri);

$method = $_SERVER['REQUEST_METHOD'];

if (($uri === "/" || $uri === "/index") && $method === 'GET') {
  Utils::jsonResponse([
    "success" => false,
    "message" => "id e nome são obrigatórios"
  ], 200); 
  exit;
}

else if ($uri === "/login" && $method === 'POST') {
    (new AuthController())->loginApi();
}

else if ($uri === "/signup" && $method === 'POST') {
    (new AuthController())->signupApi();
 
}

else if ($uri === "/home" && $method === 'GET') {
  AuthMiddlewareApi::check();

  $products = (new ProductController())->getAllProductsPai();
}

else if (preg_match('#^\/products\/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $productId = $matches[1];
    AuthMiddlewareApi::check();

    $product = (new ProductController())->findProductById($productId);
}

else if (preg_match('#^\/productspai\/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $productPaiId = $matches[1];
    AuthMiddlewareApi::check();

    $product = (new ProductController())->findProductPaiById($productPaiId);
}

else if (preg_match('#^\/byproductspai\/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $productPaiId = $matches[1];
    AuthMiddlewareApi::check();

    $product = (new ProductController())->getProductsByPaiId($productPaiId);
}

else if (preg_match('#^\/users\/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $userId = $matches[1];
    AuthMiddlewareApi::check();

    (new UserController())->findUserById($userId);
}

else if (preg_match('#^\/profile\/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $userId = $matches[1];
    AuthMiddlewareApi::check();

    (new UserController())->getProfileById($userId);
}

else if ($uri === "/carrinho_produtos" && $method === 'POST') {
    AuthMiddlewareApi::check();

    (new CarrinhoProdutosController())->createCarrinhoProduto();
}

else if (preg_match('#^\/carrinho_produtos\/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $userId = $matches[1];
    AuthMiddlewareApi::check();

    (new CarrinhoProdutosController())->findCarrinhoProdutosByUserId($userId);
}

else if (preg_match('#^\/carrinho_produtos\/(\d+)$#', $uri, $matches) && $method === 'PATCH') {
    $userId = $matches[1];
    AuthMiddlewareApi::check();

    (new CarrinhoProdutosController())->updateQtdCarrinhoProduto($userId);
}

else if (preg_match('#^\/carrinho_produtos\/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    $carrinhoProdutoId = $matches[1];
    AuthMiddlewareApi::check();

    (new CarrinhoProdutosController())->deleteCarrinhoProduto($carrinhoProdutoId);
}

else if ($uri === "/wishlist_produtos" && $method === 'POST') {
    AuthMiddlewareApi::check();

    (new WishlistProdutosController())->createWishlistProduto();
}

else if (preg_match('#^\/wishlist_produtos\/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $userId = $matches[1];
    AuthMiddlewareApi::check();

    (new WishlistProdutosController())->findWishlistProdutosByUserId($userId);
}

else if (preg_match('#^\/wishlist_produtos\/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    $wishlistProdutoId = $matches[1];
    AuthMiddlewareApi::check();

    (new WishlistProdutosController())->deleteWishlistProduto($wishlistProdutoId);
}

else if ($uri === "/pedido_produtos" && $method === 'POST') {
    AuthMiddlewareApi::check();

    (new PedidoProdutosController())->finalizarCompra();
}

else if ($uri === "/posts" && $method === 'GET') {
    AuthMiddlewareApi::check();

    (new PostController())->getAllPosts();
}

else if ($uri === "/posts" && $method === 'POST') {
    AuthMiddlewareApi::check();

    (new PostController())->createPost();
}

else if (preg_match('/^\/posts\/(\d+)$/', $uri, $matches) && $method === 'DELETE') {
    AuthMiddlewareApi::check();
    
    $postId = $matches[1];
    (new PostController())->deletePost($postId);
}

else if (preg_match('/^\/posts\/(\d+)$/', $uri, $matches) && $method === 'PUT') {
    AuthMiddlewareApi::check();

    $postId = $matches[1];
    (new PostController())->updatePost($postId);
}

else if (preg_match('#^\/posts\/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $postId = $matches[1];
    AuthMiddlewareApi::check();

    (new PostController())->findPostById($postId);
}

else if (preg_match('/^\/posts\/(\d+)\/comentarios$/', $uri, $matches) && $method === 'GET') {
    AuthMiddlewareApi::check();
    $postId = $matches[1];
    (new ComentarioController())->getComentariosByPostId($postId);
}

else if (preg_match('#^/posts/(\d+)/comentarios$#', $uri, $matches) && $method === 'POST') {
    $userStd = AuthMiddlewareApi::check();
    $postId = $matches[1];
    (new ComentarioController())->createComentario($postId, $userStd);
}

else if (preg_match('/^\/comentarios\/(\d+)\/respostas$/', $uri, $matches) && $method === 'GET') {
    AuthMiddlewareApi::check();
    $comentarioId = $matches[1];
    (new ComentarioController())->getRespostasByComentarioId($comentarioId);
}



// Rota não encontrada
else {

  $dataResponse = [
    'success' => false,
    'message' => 'Rota não encontrada',
    'data' => []
  ];
  Utils::jsonResponse($dataResponse, 404);
}
?>
