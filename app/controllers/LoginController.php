<?php
require_once __DIR__ . '/../../config/config.php';
require_once APP_PATH . '/models/User.php';

class LoginController {
    public function login() {
        global $db;
        $userModel = new User($db);

        $login = $_POST['login'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $user = $userModel->authenticate($login, $senha);

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['login'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header('Location: /public/index.php?page=site');
            exit;
        } else {
            $_SESSION['error'] = 'Usuário ou senha inválidos.';
            header('Location: /public/index.php?page=login');
            exit;
        }
    }
}
?>