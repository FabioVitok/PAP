<?php
require_once __DIR__ . '/../dao/CarrinhoProdutosDAO.php';
 
class CarrinhoProdutosController
{
    private function view($name, $data = []){
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function findCarrinhoProdutosByUserId($userId) {
        try{
            $carrinhoProdutos = (new CarrinhoProdutosDAO())->findCarrinhoProdutosByUserId($userId);

             if(!$carrinhoProdutos) {
                throw new Exception("Produto não encontrado.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'carrinho_produtos' => $carrinhoProdutos
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

    public function deleteCarrinhoProduto($carrinhoProdutoId) {
        try {
            $user = AuthMiddlewareApi::getUser();
            $result = (new CarrinhoProdutosDAO())->deleteCarrinhoProduto($carrinhoProdutoId, $user->id);
    
            if(!$result) {
                throw new Exception("Erro ao deletar o produto do carrinho.");
            }
    
            $dataResponse = [
                'success' => true,
                'message' => "Produto deletado com sucesso do carrinho",
                'data'    => []
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