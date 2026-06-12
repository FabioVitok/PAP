<?php

class JwtConfig {

    public static function getSignature(): string {
        $secret = $_ENV['JWT_SECRET'] ?? null;

        if (!$secret) {
            throw new \RuntimeException('JWT_SECRET não definido!');
        }

        return $secret;
    }

    public static function getConfig(mixed $data): array {
        return [
            'iat' => time(),
            'exp' => time() + 3600,
            'data' => $data
        ];
    }
}

?>
