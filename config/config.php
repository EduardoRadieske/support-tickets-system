<?php
    require_once 'db.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    define('BASE_PATH', dirname(__DIR__));
    define('APP_PATH', BASE_PATH . '/app');
    define('VIEW_PATH', APP_PATH . '/views');
    define('CONTROLLER_PATH', APP_PATH . '/controllers');

    $envs = parse_ini_file('config.ini');

    define('CONFIG_INI', $envs);

    // Create DB connection
    $db = Db::getConnection();
?>