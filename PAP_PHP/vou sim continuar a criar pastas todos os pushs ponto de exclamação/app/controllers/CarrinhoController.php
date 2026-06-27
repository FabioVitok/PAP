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
            $carrinho = (new CarrinhoDAO())->findCarrinhoById($carrinhoId);

             if(!$carrinho) {
                throw new Exception("Carrinho não encontrado.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'carrinho' => $carrinho
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

    public function findCarrinhoByUserId($userId) {
        try{
            $carrinho = (new CarrinhoDAO())->findCarrinhoByUserId($userId);

             if(!$carrinho) {
                throw new Exception("Carrinho não encontrado.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'carrinho' => $carrinho->toArray()
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