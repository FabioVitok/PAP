<?php

class UploadService {

    private string $pastaDestino;
    private array $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
    private int $tamanhoMax = 2097152; // 2MB

    public function __construct(string $pastaDestino = null) {
        $this->pastaDestino = $pastaDestino
            ?? dirname(__DIR__, 2) . '/public/assets/images/users/';
    }

    public function upload(array $ficheiro, int $userId): string {
        if ($ficheiro['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Erro no upload do ficheiro.');
        }

        if ($ficheiro['size'] > $this->tamanhoMax) {
            throw new Exception('Ficheiro demasiado grande (máx. 2MB).');
        }

        $extensao = strtolower(pathinfo($ficheiro['name'], PATHINFO_EXTENSION));

        if (!in_array($extensao, $this->extensoesPermitidas)) {
            throw new Exception('Tipo de ficheiro não permitido.');
        }

        if (!is_dir($this->pastaDestino)) {
            mkdir($this->pastaDestino, 0755, true);
        }

        $nomeUnico = $userId . '.' . $extensao;

        if (!move_uploaded_file($ficheiro['tmp_name'], $this->pastaDestino . $nomeUnico)) {
            throw new Exception('Não foi possível guardar a imagem.');
        }

        return 'assets/images/users/' . $nomeUnico;
    }
}