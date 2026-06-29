<?php
require_once __DIR__ . '/../models/WishlistProdutos.php';
require_once __DIR__ . '/../dao/WishlistProdutosDAO.php';
require_once __DIR__ . '/../dao/WishlistDAO.php';
require_once __DIR__ . '/../dao/ProductDAO.php';
require_once __DIR__ . '/../dao/ProductPaiDAO.php';
 
class WishlistProdutosController
{
    private function view($name, $data = []){
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function findWishlistProdutosByUserId($userId) {
        try{
            $wishlistProdutos = (new WishlistProdutosDAO())->findWishlistProdutosByUserId($userId);

             if(!$wishlistProdutos) {
                throw new Exception("WishlistProduto não encontrado.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'wishlist_produtos' => $wishlistProdutos
                ]
            ];

            Utils::jsonResponse($dataResponse, 200);
            
        } catch(Exception $e) {
        $dataResponse = [
            'success' => false,
            'message' => $e->getMessage(),
            'data'    => []
        ];

        Utils::jsonResponse($dataResponse, 401);
       }
    }

    public function createWishlistProduto() {
        try {
            $raw = file_get_contents("php://input");
            $data = json_decode($raw, true);

            if(!is_array($data)) {
                throw new Exception("JSON invalido.");
            }

            $id_wishlist = $data['id_wishlist'] ?? null;
            $id_produtopai = $data['id_produtopai'] ?? null;
            
            $wishlist = (new WishlistProdutosDAO())->findWishlistProdutoById($id_wishlist);
            if(!$wishlist) {
                throw new Exception("Wishlist não encontrado.");
            }

            $produtopai = (new ProductPaiDAO())->findProductPaiById($id_produtopai);
             if(!$produtopai) {
                throw new Exception("Produto Pai não encontrado.");
            }

            $wishlistProduto = new WishlistProdutos();
            $wishlistProduto->setIdWishlist($id_wishlist);
            $wishlistProduto->setIdProdutopai($id_produtopai);

            $createdWishlistProduto = (new WishlistProdutosDAO())->createWishlistProduto($wishlistProduto);

            $dataResponse = [
                'success' => true,
                'message' => "Produto adicionado com sucesso ao Wishlist",
                'data'    => [
                    'Wishlist_produto' => $createdWishlistProduto->toArray()
                ]
            ];
            Utils::jsonResponse($dataResponse, 201);
            exit;
        } catch (Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => []
            ];
            Utils::jsonResponse($dataResponse, 400);
        }
    }

    public function deleteWishlistProduto($wishlistProdutoId) {
        try {
            $user = AuthMiddlewareApi::getUser();

            $wishlistProduto = (new WishlistProdutosDAO())->findWishlistProdutoById($wishlistProdutoId);

            if(!$wishlistProduto) {
                throw new Exception("Produto não encontrado no Wishlist.");
            }

            $produtopai = (new ProductPaiDAO())->findProductPaiById((int)$wishlistProduto->getIdProdutopai());

            if(!$produtopai) {
                throw new Exception("Produto não encontrado no Wishlist.");
            }

            $result = (new WishlistProdutosDAO())->deleteWishlistProduto($wishlistProdutoId, $user->id);
    
            if(!$result) {
                throw new Exception("Erro ao deletar o produto do Wishlist.");
            }
    
            $dataResponse = [
                'success' => true,
                'message' => "Produto deletado com sucesso do Wishlist",
                'data'    => [
                    'produto' => $produtopai->toArray()
                ]
            ];
    
            Utils::jsonResponse($dataResponse, 200);
    
        } catch(Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => []
            ];
    
            Utils::jsonResponse($dataResponse, 401);
        }
    }
}