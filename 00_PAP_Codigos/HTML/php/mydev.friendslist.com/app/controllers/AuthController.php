<?php

require_once __DIR__ . '/../dao/UserDao.php';

class AuthController
{

    private function view($name)
    {
        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function loginWeb()
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $passwordEncript = password_hash($password, PASSWORD_DEFAULT);

        var_dump($passwordEncript);

        if (empty($email) || empty($password)) {
            die('Email e pass são obrigatórios');
        }

        $user = (new UserDAO())->findByEmail($email);

        if(!$user) {
            die('Email ou password inválidos');
        }
    }

    public function signupWeb()
    {
    /**
     * 1. Validar se existe user logado
     */

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception('Username, email e password são obrigatórios');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Dados inválidos');
        }

        $userDao = new UserDAO();

        if ($userDao->findByEmail($email)) {
            throw new Exception('Email já registrado');
        }

        //$passwordEncript = password_hash($password, PASSWORD_DEFAULT);

        $userDao->create($username, $email, $passwordEncript);

    }
}