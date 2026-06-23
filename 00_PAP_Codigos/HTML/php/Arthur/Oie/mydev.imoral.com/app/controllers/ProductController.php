<?php
require_once __DIR__ . '/../dao/ProductDAO.php';
require_once __DIR__ . '/../dao/ProductPaiDAO.php';

class ProductController
{
    private function view($name, $data = []) {
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../../public/views/' . $name . '.php';
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

    public function findProductPaiById(int $productPaiId) {
        try {
            $productPai = (new ProductPaiDAO())->findProductPaiById($productPaiId);

            if (!$productPai) {
                throw new Exception("Produto Pai não encontrado.");
            }

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'productPai' => $productPai->toArray()
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

    public function store(array $dados) {
        $idProdutoPai = (int)($dados['id_produto_pai'] ?? 0);
        $tamanho = trim($dados['tamanho'] ?? '');
        $peso = (float)($dados['peso'] ?? 0);
        $preco_custo = (float)($dados['preco_custo'] ?? 0);
        $stock = (int)($dados['stock'] ?? 0);

        if (empty($tamanho) || $peso <= 0 || $preco_custo <= 0) {
            Utils::jsonResponse(['success' => false, 'message' => 'Tamanho, peso e preço de custo são obrigatórios.'], 400);
            return;
        }

        $productDAO = new ProductDAO();
        $idProduto = $productDAO->createProduct($idProdutoPai, $tamanho, $peso, $preco_custo, $stock);

        Utils::jsonResponse([
            'success' => true,
            'id_produto_pai' => $idProdutoPai,
            'id_produto' => $idProduto,
            'tamanho' => $tamanho,
            'peso' => $peso,
            'preco_custo' => $preco_custo,
            'stock' => $stock
        ], 201);
    }

    public function storePai(array $dados) {
        $nome        = trim($dados['nome'] ?? '');
        $tipo        = trim($dados['tipo'] ?? '');
        $cor         = $dados['cor'] ?? null;
        $image       = $dados['image'] ?? null;
        $preco_venda = (float)($dados['preco_venda'] ?? 0);

        if (empty($nome) || empty($tipo) || $preco_venda <= 0) {
            Utils::jsonResponse(['success' => false, 'message' => 'Nome, tipo e preço de venda são obrigatórios.'], 400);
            return;
        }

        $id = (new ProductPaiDAO())->createProductPai($nome, $tipo, $cor, $image, $preco_venda);

        Utils::jsonResponse([
            'success'     => true,
            'id'          => $id,
            'nome'        => $nome,
            'tipo'        => $tipo,
            'cor'         => $cor ?? '',
            'image'       => $image ?? '',
            'preco_venda' => $preco_venda,
        ], 201);
    }

    public function update(int $productId) {
        $product = (new ProductDAO())->findById($productId);

        if (!$product) {
            throw new Exception("Produto não encontrado.");
        }

        if (!AuthMiddlewareWeb::canEditProduct($productId)) {
            throw new Exception("Acesso negado.");
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

    public function delete(int $productId) {
        $product = (new ProductDAO())->findById($productId);

        if (!$product) {
            throw new Exception("Produto não encontrado.");
        }

        $result = (new ProductDAO())->deleteProduct($productId);

        if (!$result) {
            throw new Exception("Erro ao eliminar produto.");
        }
    }
}