<?php
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/EmailVerificationDAO.php';
require_once __DIR__ . '/../utils/Utils.php';
 
class UserController
{
    private function view($name, $data = [])
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function profile($userId) {
        $user = (new UserDAO())->findUserByIdDash($userId);
        if(!$user) {
            die("Utilizador não encontrado.");
        }
        $this->view('user/profile', ['user' => $user]);
    }

    public function update($userId) {
        $user = (new UserDAO())->findUserById($userId);

        if(!$user) {
            die("Utilizador não encontrado.");
        }

        if(!AuthMiddlewareWeb::canEditProfile($userId)) {
            die("Acesso negado.");
        }

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';

        if(empty($username) || empty($email)) {
            throw new Exception("Username e email são obrigatórios.");
        }

        $result = (new UserDAO())->updateUser($userId, $username, $email);
        
        if(! $result) {
            throw new Exception("Erro ao atualizar dados.");
        }

        if (AuthMiddlewareWeb::canEditProfile($userId)) {
        //if($userId == $_SESSION['token']['id']) {
            $_SESSION['token']['username'] = $username;
            $_SESSION['token']['email'] = $email;
        }

    }

    public function getUsers() {
        $users = (new UserDAO())->getUsersDao();
    }

    public function getAllUsers($userId) {
        try {
            $users = (new UserDAO())->arrayUsersDAO();
            $emailsVerification = (new EmailVerificationDAO())->getVerificationsByUserId($userId);
            $countUsers = (new UserDAO())->countUsers();
            $countEmailsVerification = (new EmailVerificationDAO())->countVerifications();

            $dataResponse = [
                'success' => true,
                'message' => "Operação realizada com sucesso",
                'data'    => [
                    'users' => $users,
                    'emails_verification' => $emailsVerification,
                    'num_users' => $countUsers,
                    'num_emails' => $countEmailsVerification
                ]
            ];

            Utils::jsonResponse($dataResponse, 200);

       }catch(Exception $e) {
        $dataResponse = [
            'success' => false,
            'message' => $e->getMessage(),
            'data'    => []
        ];

        Utils::jsonResponse($dataResponse, 401);
       }
    }

    public function findUserById($userId) {
        
        try{
        $user = (new UserDAO())->findUserById($userId);

        if(!$user) {
            throw new Exception("Utilizador não encontrado.");
        }

        $dataResponse = [
            'success' => true,
            'message' => "Operação realizada com sucesso",
            'data'    => [
                'user' => $user
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

    public function activateUser(int $userId) {
        (new UserDAO())->setUserEstado($userId, 9); // 9 = Conta Ativa
        Utils::jsonResponse(['success' => true], 200);
    }

    public function suspendUser(int $userId) {
        (new UserDAO())->setUserEstado($userId, 8); // 8 = Conta Suspensa
        Utils::jsonResponse(['success' => true], 200);
    }

    public function deleteUser(int $userId) {
        $deletedAt = (new UserDAO())->deleteUser($userId, 7); // 7 = Conta Banida
        Utils::jsonResponse(['success' => true, 'deleted_at' => $deletedAt], 200);
    }

    public function unbanUser(int $userId) {
        (new UserDAO())->unbanUser($userId, 9); // 9 = Conta Ativa
        Utils::jsonResponse(['success' => true], 200);
    }
}