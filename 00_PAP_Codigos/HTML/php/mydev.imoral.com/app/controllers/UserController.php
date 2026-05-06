<?php
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/EmailVerificationDAO.php';
 
class UserController
{
    private function view($name, $data = [])
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../../public/views/' . $name . '.php';
    }

    public function profile($id) {
        $user = (new UserDAO())->findById($id);
        if(!$user) {
            die("Usuário não encontrado.");
        }
        $this->view('user/profile', ['user' => $user]);
    }
}