<?php

class ContactController {
    public function send() {
        $name    = trim($_POST['name']    ?? '');
        $email   = trim($_POST['email']   ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (!$name || !$email || !$subject || !$message) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido.");
        }

        $html = "
            <div style='font-family: Arial, sans-serif;'>
                <h2>Nova mensagem de contacto</h2>
                <p><strong>Nome:</strong> " . htmlspecialchars($name) . "</p>
                <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                <p><strong>Assunto:</strong> " . htmlspecialchars($subject) . "</p>
                <p><strong>Mensagem:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
            </div>
        ";

        (new Mailer())->send('SendUsAMessage@imoral.com', $subject, $html);

        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Mensagem enviada com sucesso!'];
        header("Location: /contact");
        exit;
    }
}