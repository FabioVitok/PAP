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

    public function createComentario($postId, $utilizador){
        try{
            $raw = file_get_contents("php://input");
            $data = json_decode($raw, true);

            if(!is_array($data)) {
                throw new Exception("JSON invalido.");
            }

            //$userId = $data['id_utilizador'] ?? null;
            $texto_comentario = $data['texto_comentario'] ?? null;
            $id_comentario_pai = $data['id_comentario_pai'] ?? null;

            //$utilizador = (new UserDAO())->findUserById($userId);
            if(!$utilizador) {
                throw new Exception("Utilizador não encontrado.");
            }

            $post = (new PostDAO())->findPostById($postId);
            if(!$post) {
                throw new Exception("Post não encontrado.");
            }

            if(!$texto_comentario) {
                throw new Exception("texto é obrigatório.");
            }

            $comentario = new comentario();
            $comentario->setIdUtilizador($utilizador->id);
            $comentario->setTextocomentario($texto_comentario);
            $comentario->setIdPost($postId);

        
            if($id_comentario_pai !== null) {
                $comentario_pai = (new ComentarioDAO())->findComentarioById($id_comentario_pai);
                if(!$comentario_pai) {
                    throw new Exception("Comentario não encontrado.");
                }
                $comentario->setIdComentarioPai($id_comentario_pai);
            }


            $createdcomentario = (new comentarioDAO())->createComentario($comentario);

            if(!$createdcomentario) {
                throw new Exception("Erro ao criar o comentario.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'comentarios' => $createdcomentario->toArray()
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