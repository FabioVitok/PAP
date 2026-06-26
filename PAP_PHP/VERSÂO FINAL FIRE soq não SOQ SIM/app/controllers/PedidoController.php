<?php
require_once __DIR__ . '/../dao/PedidoDAO.php';
 
class PedidoController
{
    private function view($name, $data = []){
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function findPedidoById($pedidoId) {
        try{
            $pedido = (new PedidoDAO())->findPedidoById($pedidoId);

             if(!$pedido) {
                throw new Exception("Pedido não encontrado.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'pedido' => $pedido
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