<?php

class WebController {
    

    private function view($viewName, $data = []) {
        require_once __DIR__ . "/../../public/views/{$viewName}.php";
    }

    public function index() {        
        $this->view('home');
    }

    /*public function paginaPrivada() {
        $this->view('private');
    }*/

    public function login() {
        $this->view('login');
    }

    public function loginWeb() {
        
    }

    public function signup() {
        $this->view('signup');
    }

    public function users() {
        $this->view('users');
    }

    public function badRequest() {
        $this->view('errors/400');
    }
}