<?php
require_once __DIR__ . '/../dao/CarrinhoDAO.php';
 
class CarrinhoController
{
    private function view($name, $data = []){
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function findCarrinhoById($carrinhoId) {
        try{
            $carrinhoProdutos = (new CarrinhoDAO())->findCarrinhoById($carrinhoId);

             if(!$carrinhoProdutos) {
                throw new Exception("Carrinho não encontrado.");
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
/**
    public function createCarrinhoProduto() {
        try {
            $raw = file_get_contents("php://input");
            $data = json_decode($raw, true);

            if(!is_array($data)) {
                throw new Exception("JSON invalido.");
            }

            $id_carrinho = $data['id_carrinho'] ?? null;
            $id_produto = $data['id_produto'] ?? null;
            $quantidade = $data['quantidade'] ?? null;
            
            $carrinho = (new CarrinhoDAO())->findCarrinhoById($id_carrinho);
            if(!$carrinho) {
                throw new Exception("Carrinho não encontrado.");
            }

            $produto = (new ProductDAO())->findProductById($id_produto);
             if(!$produto) {
                throw new Exception("Produto não encontrado.");
            }

            if(!$quantidade) {
                throw new Exception("quantidade é obrigatória.");
            }

            $carrinhoProduto = new CarrinhoProduto();
            $carrinhoProduto->setIdCarrinho($id_carrinho);
            $carrinhoProduto->setIdProduto($id_produto);
            $carrinhoProduto->setQuantidade($quantidade);

            $createdCarrinhoProduto = (new CarrinhoProdutosDAO())->createCarrinhoProduto($carrinhoProduto);

            $dataResponse = [
                'success' => true,
                'message' => "Produto adicionado com sucesso ao carrinho",
                'data'    => [
                    'carrinho_produto' => $createdCarrinhoProduto->arrayCarrinhoProduto()
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
*/
}