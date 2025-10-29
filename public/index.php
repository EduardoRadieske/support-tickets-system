<?php
require_once __DIR__ . '/../config/config.php';

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'login':
        require VIEW_PATH . '/login.php';
        break;
    case 'site':
        require APP_PATH . '/controllers/SiteController.php';
        $controller = new SiteController();
        $controller->index();
        break;
    case 'doLogin':
        require APP_PATH . '/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->login();
        break;
    case 'logout':
        session_destroy();
        header('Location: /public/index.php?page=login');
        break;
    default:
        require VIEW_PATH . '/errors/404.php';
        break;
}
?>