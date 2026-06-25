<?php
require_once __DIR__ . '/../models/Comentario.php';
require_once __DIR__ . '/../dao/ComentarioDAO.php';
require_once __DIR__ . '/../dao/UserDAO.php';
 
class ComentarioController
{
    private function view($name, $data = []){
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }


    public function getComentariosByPostId($postId) {
        try {
            $comentarios = (new ComentarioDAO())->getComentariosByPostId($postId);

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'comentarios' => array_map(fn($comentario) => $comentario->toArray(), $comentarios)
                ]
            ];

            Utils::jsonResponse($dataResponse, 200);

        } catch(Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => []
            ];

            Utils::jsonResponse($dataResponse, 400);
        }
    }

    public function getRespostasByComentarioId($CommentId) {
        try {
            $comentarios = (new ComentarioDAO())->getRespostasByComentarioId($CommentId);

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'comentarios' => array_map(fn($comentario) => $comentario->toArray(), $comentarios)
                ]
            ];

            Utils::jsonResponse($dataResponse, 200);

        } catch(Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => []
            ];

            Utils::jsonResponse($dataResponse, 400);
        }
    }
}