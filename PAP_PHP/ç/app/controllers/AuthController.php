<?php

require_once __DIR__ . '/../services/UploadService.php';
require_once __DIR__ . '/../services/Mailer.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/CarrinhoDAO.php';
require_once __DIR__ . '/../dao/WishlistDAO.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../dao/EmailVerificationDAO.php';
require_once __DIR__ . '/../config/jwtConfig.php'; 

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController{
 
  private function view($name, $data = []){
    extract($data, EXTR_SKIP);
   
    require __DIR__ . '/../../public/views/' . $name . '.php';
  }
 
  public function loginWeb() {
    try {

      $email = trim($_POST['email'] ?? '');
      $password = trim($_POST['password'] ?? '');

      if(empty($email) || empty($password)) {
        die("Email e password são obrigatórios");
      }
  
      $user = (new UserDAO())->findByEmail($email);

      if (! $user || ! password_verify($password, $user->getPassword())) {
        throw new Exception("Email ou password errados");
      }

      if($user->getDeletedAt() !== NULL)  {
        throw new Exception("Conta Banida");
      }

      $carrinho = (new CarrinhoDAO())->findCarrinhoByUserId($user->getId());

      if (!$carrinho) {
        throw new Exception("Carrinho não encontrado para o utilizador.");
      }

      $wishlist = (new WishlistDAO())->findWishlistByUserId($user->getId());

      if (!$wishlist) {
        throw new Exception("Wishlist não encontrada para o utilizador.");
      }

      $image = $user->getImage();

      $expectedPrefix = 'assets/images/users/' . $user->getId();
      if (!$image || (!str_starts_with($image, $expectedPrefix) && $image !== 'assets/images/users/user_icon.png')) {
          $image = null;
      }

      $_SESSION['token'] = [
          'id' => $user->getId(),
          'username' => $user->getUsername(),
          'email' => $user->getEmail(),
          'is_admin' => $user->isAdmin(),
          'image' => $image
      ];

      $_SESSION['toast'] = [
        'type' => 'success',
        'message' => 'Bem vindo de volta, ' . $user->getUsername() . "!"
      ];

      header("Location: /");
      exit;

    } catch(Exception $e) {

      $_SESSION['toast'] = [
        'type' => 'error',
        'message' => $e->getMessage()
      ];

      header("Location: /login");
      exit;
    }

  }

  public function logoutWeb() {
    unset($_SESSION['token']);

    $_SESSION['toast'] = [
      'type' => 'success',
      'message' => 'Logout efetuado com sucesso.'
    ];

    
    header("Location: /");
    exit;
  }
 
  public function signupWeb() {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
 
    if($username === '' || $email === '') {
      throw new Exception("Username e email são obrigatórios");
    }
 
    if(! filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Dados inválidos");
    }
 
    // Verificar se email já existe
    $user = (new UserDAO())->findByEmail($email);

    if($user) {
      throw new Exception("Email já existe");
    }

    $userDAO = new UserDAO();
    $userId = $userDAO->createPending($username, $email, null);

    $caminhoImagem = null;
    if (!empty($_FILES['image']['name'])) {
        $caminhoImagem = (new UploadService())->upload($_FILES['image'], $userId);
        $userDAO->updateImage($userId, $caminhoImagem);
    }
   
    // Criar token de verificação
    $verDAO = new EmailVerificationDAO();
 
    $token = $verDAO->createForUser($userId, 300);
 
    // 3) baseUrl dinâmico (vhosts)
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $baseUrl = $scheme . '://' . $host;
   
    // 4) link para clicar no email
    $link = $baseUrl . "/verify-email?token=" . urlencode($token);
   
    // 5) envia email via Mailer (PHPMailer/Mailtrap)
    $subject = "Verifique o seu email (expira em 5 min)";

    $templatePath = __DIR__ . '/../../public/views/emails/welcome.php';
    $html = file_get_contents($templatePath);

    // basicamente pega a imagem coloca ela em memoria
    $imgPath = __DIR__ . '/../../public/assets/images/carousel_image3.jpg';

    $src  = imagecreatefromjpeg($imgPath);
    $w    = imagesx($src);
    $h    = imagesy($src);
    $size = min($w, $h);
    $x    = intval(($w - $size) / 2);
    $y    = intval(($h - $size) / 2);

    // guarda outra imagem em memoria so que com o crop
    $cropped = imagecreatetruecolor($size, $size);
    imagecopyresampled($cropped, $src, 0, 0, $x, $y, $size, $size, $size, $size);

    // manda para o html
    ob_start();
    imagejpeg($cropped, null, 90);
    $imgSrc = 'data:image/jpeg;base64,' . base64_encode(ob_get_clean());

    // liberta memoria
    imagedestroy($src);
    imagedestroy($cropped);

    $logoPath = __DIR__ . '/../../public/assets/images/imoral_logo1_transp.png';
    $logoSrc  = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

    date_default_timezone_set('Europe/Lisbon');
    $expiry = date('d/m/Y H:i', strtotime('+5 minutes'));

    $html = str_replace(
        ['{{LOGO}}', '{{IMAGE}}', '{{USERNAME}}', '{{LINK}}', '{{EXPIRY}}'],
        [$logoSrc, $imgSrc, htmlspecialchars($username), $link, $expiry],
        $html
    );

    (new Mailer())->send($email, $subject, $html);
 
    // 6) redirect com toast
    $_SESSION['toast'] = [
      'type' => 'success',
      'message' => "Conta criada. Enviámos um email para verificares (link expira em 5 min)."
    ];

 
      header("Location: /login");
    exit;
  }
 
  public function adminCreateUser() {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email']    ?? '');

    if (empty($username) || empty($email)) {
        throw new Exception("Username e email são obrigatórios.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email inválido.");
    }

    $user = (new UserDAO())->findByEmail($email);
    if ($user) {
        throw new Exception("Email já existe.");
    }

    $userDAO = new UserDAO();
    $userId  = $userDAO->createPending($username, $email, null);

    $verDAO = new EmailVerificationDAO();
    $token  = $verDAO->createForUser($userId, 300);

    $scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host    = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $link    = $scheme . '://' . $host . '/verify-email?token=' . urlencode($token);

    $subject = "A tua conta foi criada (verifica o email)";
    $html    = "
        <div style='font-family: Arial, sans-serif;'>
            <h2>Olá, " . htmlspecialchars($username) . "!</h2>
            <p>A tua conta foi criada por um administrador. Clica no link para definires a tua password (válido por <b>5 minutos</b>):</p>
            <p><a href='{$link}'>{$link}</a></p>
        </div>
    ";

    (new Mailer())->send($email, $subject, $html);
  }

  public function verifyEmailForm() {
    $token = $_GET['token'] ?? '';
   
    if(empty($token)) {
      header("Location: /bad-request");
    }
 
    $this->view('verify-email', ['token' => $token]);
 
  }
 
  public function verifyEmailSubmit() {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
 
    if(empty($token) || empty($password)) {
      throw new Exception("Dados inválidos");
    }
 
    // Verificar validade do token
    $verDAO = new EmailVerificationDAO();
 
    $userId = $verDAO->validateToken($token);
 
    //var_dump("UserId encontrado para o token: " . $userId);
    if(!$userId) {
      throw new Exception("Token inválido ou expirado");
    }
 
    $hash = password_hash($password, PASSWORD_DEFAULT);
 
    $userDao = new UserDAO();
    $userDao->setPasswordAndVerify($userId, $hash);
 
    $verDAO->markUsed($token);
 
    $_SESSION['toast'] = [
      'type' => 'success',
      'message' => "Email verificado e password definida. Já podes fazer login."
    ];
    header("Location: /login");
    exit;
  }

  public function loginApi() {
    try {
      $body = json_decode(file_get_contents('php://input'), true);

      $email    = trim($body['email'] ?? $_POST['email'] ?? '');
      $password = trim($body['password'] ?? $_POST['password'] ?? '');

      // Se não houver email ou password, mostrar erro
      // é preciso lançar exceção para o index.php apanhar e mostrar o erro via flash message
      if (empty($email) || empty($password)) {
        throw new Exception("Email e password são obrigatórios");
      }
 
      $user = (new UserDAO())->findByEmail($email);

      if (! $user || ! password_verify($password, $user->getPassword())) {
        throw new Exception("Email ou password errados");
      }

      if($user->getDeletedAt() !== NULL)  {
        throw new Exception("Conta Banida");
      }
      
      $carrinho = (new CarrinhoDAO())->findCarrinhoByUserId($user->getId());

      if (!$carrinho) {
        throw new Exception("Carrinho não encontrado para o utilizador.");
      }
 
      $wishlist = (new WishlistDAO())->findWishlistByUserId($user->getId());

      if (!$wishlist) {
        throw new Exception("Wishlist não encontrada para o utilizador.");
      }

      $data = [
        'id' => $user->getId(),
        'role' => $user->isAdmin()
      ];

      $payload = jwtConfig::getConfig($data);
 
      $jwt = JWT::encode($payload, jwtConfig::getSignature(), "HS256");
 
      $dataResponse = [
        'success' => true,
        'message' => "Login efetuado com sucesso",
        'data'    => [
          'jwt' => $jwt,
          'user' => [
            'id' => $user->getId(),
            'is_admin' => $user->isAdmin(),
            'username' => $user->getUsername(),
            'image' => $user->getImage(),
          ],
          'carrinho' => $carrinho->toArray(),
          'wishlist' => $wishlist->toArray()
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

  public function signupApi() {
    try {
        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            throw new Exception('Método não permitido');
        }

        if (!is_array($data) || count($data) < 4) {
          throw new Exception('Dados insuficientes');
        }

        if (!isset($data['username'], $data['email'], $data['password'], $data['confirm_password'])) {
            throw new Exception('Dados insuficientes. Todos os campos são obrigatórios');
        }

        $email           = trim($data['email']);
        $username        = trim($data['username']);
        $password        = trim($data['password']);
        $confirmPassword = trim($data['confirm_password']);
 
        if ($username === '' || $email === '' || $password === '' || $confirmPassword === '') {
            throw new Exception('Todos os campos são obrigatórios');
        }

        // verificar se email já existe
        $user = (new UserDAO())->findByEmail($email);
 
        if($user) {
          throw new Exception("Email já existe");
        }
 
        if ($password !== $confirmPassword) {
          throw new Exception('As passwords não coincidem');
        }
 
        $userDAO = new UserDAO();
      
        $userId = $userDAO->createPending($username, $email, null);
        $caminhoImagem = null;

        $carrinho = (new CarrinhoDAO())->createCarrinho($userId);

        if (!$carrinho) {
          throw new Exception("Falha ao criar Carrinho para o utilizador.");
        }

        $wishlist = (new WishlistDAO())->createWishlist($userId);

        if (!$wishlist) {
          throw new Exception("Falha ao criar Wishlist para o utilizador.");
        }

        if (!empty($_FILES['image']['name'])) {
            $caminhoImagem = (new UploadService())->upload($_FILES['image'], $userId);
            $userDAO->updateImage($userId, $caminhoImagem);
        }

        $verDAO = new EmailVerificationDAO();
        $token = $verDAO->createForUser($userId, 300);
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $baseUrl = $scheme . '://' . $host;
        $link = $baseUrl . "/verify-email?token=" . urlencode($token);
        $subject = "Verifique o seu email (expira em 5 min)";

        $templatePath = __DIR__ . '/../../public/views/emails/welcome.php';
        $html = file_get_contents($templatePath);

        $imgPath = __DIR__ . '/../../public/assets/images/carousel_image3.jpg';
        $src  = imagecreatefromjpeg($imgPath);
        $w    = imagesx($src);
        $h    = imagesy($src);
        $size = min($w, $h);
        $x    = intval(($w - $size) / 2);
        $y    = intval(($h - $size) / 2);
        $cropped = imagecreatetruecolor($size, $size);
        imagecopyresampled($cropped, $src, 0, 0, $x, $y, $size, $size, $size, $size);
        ob_start();
        imagejpeg($cropped, null, 90);
        $imgSrc = 'data:image/jpeg;base64,' . base64_encode(ob_get_clean());
        imagedestroy($src);
        imagedestroy($cropped);

        $logoPath = __DIR__ . '/../../public/assets/images/imoral_logo1_transp.png';
        $logoSrc  = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        date_default_timezone_set('Europe/Lisbon');
        $expiry = date('d/m/Y H:i', strtotime('+5 minutes'));

        $html = str_replace(
            ['{{LOGO}}', '{{IMAGE}}', '{{USERNAME}}', '{{LINK}}', '{{EXPIRY}}'],
            [$logoSrc, $imgSrc, htmlspecialchars($username), $link, $expiry],
            $html
        );
 
        (new Mailer())->send($email, $subject, $html);
        
        echo json_encode([
            'success' => true,
            'message' => 'Conta criada com sucesso. Verifique sua conta.',
        ]);
 
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
  }
}