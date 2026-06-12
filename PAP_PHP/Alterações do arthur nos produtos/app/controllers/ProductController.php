<?php
require_once __DIR__ . '/../dao/ProductDAO.php';
require_once __DIR__ . '/../dao/ProductPaiDAO.php';

class ProductController
{
    private function view($name, $data = []) {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function update(int $productId) {
        $product = (new ProductDAO())->findById($productId);

        if (!$product) {
            die("Produto não encontrado.");
        }

        if (!AuthMiddlewareWeb::canEditProduct($productId)) {
            die("Acesso negado.");
        }

        $tamanho    = $_POST['tamanho']    ?? '';
        $peso       = (float)($_POST['peso']       ?? 0);
        $preco_custo = (float)($_POST['preco_custo'] ?? 0);
        $stock      = (int)($_POST['stock']      ?? 0);

        if (empty($tamanho)) {
            throw new Exception("Tamanho é obrigatório.");
        }

        $result = (new ProductDAO())->updateProduct($productId, $tamanho, $peso, $preco_custo, $stock);

        if (!$result) {
            throw new Exception("Erro ao atualizar dados.");
        }
    }

    public function updatePai(int $paiId) {
        $product = (new ProductPaiDAO())->findById($paiId);

        if (!$product) {
            die("Produto não encontrado.");
        }

        $nome        = $_POST['nome']        ?? '';
        $tipo        = $_POST['tipo']        ?? '';
        $cor         = $_POST['cor']         ?? null;
        $image       = $_POST['image']       ?? null;
        $preco_venda = (float)($_POST['preco_venda'] ?? 0);

        if (empty($nome) || empty($tipo)) {
            throw new Exception("Nome e tipo são obrigatórios.");
        }

        $result = (new ProductPaiDAO())->updateProductPai($paiId, $nome, $tipo, $cor, $image, $preco_venda);

        if (!$result) {
            throw new Exception("Erro ao atualizar dados.");
        }
    }

    public function getProducts() {
        $products = (new ProductDAO())->getAll();
    }

    public function getAllProductsPai() {
        try {
            $products = (new ProductPaiDAO())->getAllProductsPai();

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => ['products' => array_map(fn($p) => $p->toArray(), $products)]
            ];

            Utils::jsonResponse($dataResponse, 200);

        } catch (Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => []
            ];

            Utils::jsonResponse($dataResponse, 401);
        }
    }

    public function findProductById(int $productId) {
        try {
            $product = (new ProductDAO())->findById($productId);

            if (!$product) {
                throw new Exception("Produto não encontrado.");
            }

            $pai = (new ProductPaiDAO())->findById($product->getIdProdutoPai());

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'product' => $product->toArray(),
                    'pai'     => $pai->toArray()
                ]
            ];

            Utils::jsonResponse($dataResponse, 200);

        } catch (Exception $e) {
            $dataResponse = [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => []
            ];

            Utils::jsonResponse($dataResponse, 401);
        }
    }
}