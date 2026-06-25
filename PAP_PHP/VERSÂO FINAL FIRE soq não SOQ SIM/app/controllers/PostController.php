<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../dao/PostDAO.php';
require_once __DIR__ . '/../dao/UserDAO.php';
 
class PostController
{
    private function view($name, $data = []){
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function findPostById($postId) {
        try{
            $post = (new PostDAO())->findPostById($postId);

             if(!$post) {
                throw new Exception("Post não encontrado.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'post' => $post->toArray()
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

    public function getAllPosts() {
        try {
            $posts = (new PostDAO())->getAllPosts();

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'posts' => array_map(fn($post) => $post, $posts)
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

    public function createPost() {
        try {
            $raw = file_get_contents("php://input");
            $data = json_decode($raw, true);

            if(!is_array($data)) {
                throw new Exception("JSON invalido.");
            }

            $id_utilizador = $data['id_utilizador'] ?? null;
            $texto_post = $data['texto_post'] ?? null;

            $id_utilizador = $data['id_utilizador'] ?? null;
            $utilizador = (new UserDAO())->findUserById($id_utilizador);
            if(!$utilizador) {
                throw new Exception("Utilizador não encontrado.");
            }

            if(!$texto_post) {
                throw new Exception("texto é obrigatório.");
            }

            $post = new Post();
            $post->setIdUtilizador($id_utilizador);
            $post->setTextoPost($texto_post);

            $createdPost = (new PostDAO())->createPost($post);

             if(!$createdPost) {
                throw new Exception("Erro ao criar o post.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Post criado com sucesso",
                'data'    => [
                    'post' => $createdPost
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

    public function deletePost($postId) {
        try {
            $user = AuthMiddlewareApi::getUser();
            $result = (new PostDAO())->deletePost($postId, $user->id);
    
            if(!$result) {
                throw new Exception("Erro ao apagar o post.");
            }
    
            $dataResponse = [
                'success' => true,
                'message' => "Post Apagado com sucesso",
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

    public function updatePost($postId) {
        try {
            $raw = file_get_contents("php://input");
            $data = json_decode($raw, true);

            if(!is_array($data)) {
                throw new Exception("JSON invalido.");
            }

            $texto_post = $data['texto_post'] ?? null;

            if(!$texto_post) {
                throw new Exception("texto é obrigatório.");
            }

            $result = (new PostDAO())->updatePost($postId, $texto_post);

            if(!$result) {
                throw new Exception("Erro ao atualizar o post.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Post atualizado com sucesso",
                'data'    => []
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