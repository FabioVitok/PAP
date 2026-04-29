<?php

require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/EmailVerificationDAO.php';

class AuthController
{

    private function view($name, $data = [])
    {
        extract($data, EXTR_SKIP);
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

        if (!$user) {
            die('Email ou password inválidos');
        }
    }

    public function signupWeb()
    {
        /**
         * @TODO validar se existe utilizador logado
         */
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $email === '') {
            throw new Exception("Username e email são obrigatórios");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido");
        }

        //Validar se o email já existe
        $user = (new UserDAO())->findByEmail($email);
        if ($user) {
            throw new Exception("Email já existe");
        }

        //Cria o utilizador no estado pendente
        $userDAO = new UserDAO();
        $userId = $userDAO->createPending($username, $email);
        $verDAO = new EmailVerificationDAO();
        $token = $verDAO->createForUser($userId, 300);

        // 3) baseUrl dinâmico (vhosts)
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $baseUrl = $scheme . '://' . $host;

        // 4) link para clicar no email
        $link = $baseUrl . "/verify-email?token=" . urlencode($token);

        // 5) envia email via Mailer (PHPMailer/Mailtrap)
        $subject = "Verifica o teu email (expira em 5 min)";
        $html = "
            <div style='font-family: Arial, sans-serif;'>
            <h2>Olá, " . htmlspecialchars($username) . "!</h2>
            <p>Para ativares a tua conta e definires a tua password, clica no link abaixo (válido por <b>5 minutos</b>):</p>
            <p><a href='{$link}'>Link de Verificação</a></p>
            <p>Se o link expirar, faz signup novamente (ou pede reenvio do link).</p>
            </div>
        ";

        (new Mailer())->send($email, $subject, $html);

        // 6) redirect com toast
        $_SESSION['flash_success'] = "Conta criada. Enviámos um email para verificares (link expira em 5 min).";
        header("Location: /login");
        exit;
    }

    public function verifyEmailForm($token)
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            header("Location: /bad-request");
            exit();
        }

        $this->view('verify-email', ['token' => $token]);
    }

}