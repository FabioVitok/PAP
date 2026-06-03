<?php
require_once __DIR__ . '/../models/PedidoProdutos.php';
require_once __DIR__ . '/../dao/PedidoProdutosDAO.php';
require_once __DIR__ . '/../dao/PedidoDAO.php';
require_once __DIR__ . '/../dao/ProductDAO.php';
 
class PedidoProdutosController
{
    private function view($name, $data = []){
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function findPedidoProdutosByUserId($userId) {
        try{
            $pedidoProdutos = (new PedidoProdutosDAO())->findPedidoProdutosByUserId($userId);

             if(!$pedidoProdutos) {
                throw new Exception("PedidoProduto não encontrado.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'pedido_produtos' => $pedidoProdutos
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

    public function createPedidoProduto() {
        try {
            $raw = file_get_contents("php://input");
            $data = json_decode($raw, true);

            if(!is_array($data)) {
                throw new Exception("JSON invalido.");
            }

            $carrinho_id = $data['carrinho_id'] ?? null;
            $id_produto = $data['id_produto'] ?? null;
            $quantidade = $data['quantidade'] ?? null;
            
            $carrinho = (new CarrinhoDAO())->findCarrinhoById($carrinho_id);
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

            $carrinhoProduto = new CarrinhoProdutos();
            $carrinhoProduto->setIdCarrinho($carrinho_id);
            $carrinhoProduto->setIdProduto($id_produto);
            $carrinhoProduto->setQuantidade($quantidade);

            $createdCarrinhoProduto = (new CarrinhoProdutosDAO())->createCarrinhoProduto($carrinhoProduto);

            $dataResponse = [
                'success' => true,
                'message' => "Produto adicionado com sucesso ao carrinho",
                'data'    => [
                    'carrinho_produto' => $createdCarrinhoProduto->toArray()
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

    public function finalizarCompra() {
        try {
            $raw  = file_get_contents("php://input");
            $data = json_decode($raw, true);

            if (!is_array($data)) {
                throw new Exception("JSON inválido.");
            }

            $carrinho_id = $data['carrinho_id'] ?? null;

            if (!$carrinho_id) {
                throw new Exception("carrinho_id é obrigatório.");
            }

            $idPedido = (new PedidoProdutosDAO())->finalizarCompra((int) $carrinho_id);

            $dataResponse = [
                'success' => true,
                'message' => "Compra finalizada com sucesso",
                'data'    => [
                    'id_pedido' => $idPedido
                ]
            ];

            Utils::jsonResponse($dataResponse, 201);

        } catch (Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => []
            ];

            Utils::jsonResponse($dataResponse, 400);
        }
    }

}