<?php
class Db {
    private static $connection;

    public static function getConnection() {
        if (!isset(self::$connection)) {
            self::initializeDatabase();
        }

        return self::$connection;
    }

    public static function createConnection() {
        $dsn = "mysql:host=" . CONFIG_INI['db_host'] . ";dbname=" . CONFIG_INI['db_name'] . ";charset=utf8mb4";
        $conn = new PDO($dsn, CONFIG_INI['db_login'], CONFIG_INI['db_pass']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $conn;
    }

    private static function initializeDatabase() {
        try {
            $dbName = CONFIG_INI['db_name'];

            $dsn = "mysql:host=" . CONFIG_INI['db_host'] . ";charset=utf8mb4";
            $pdo = new PDO($dsn, CONFIG_INI['db_login'], CONFIG_INI['db_pass']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

            self::$connection = self::createConnection();

            self::createTables(self::$connection);

            if (
                isset(CONFIG_INI['environment']) &&
                strtolower(CONFIG_INI['environment']) === 'dev'
            ) {
                self::createDevAdminUser();
            }
        } catch (PDOException $e) {
            die("Erro ao inicializar o banco: " . $e->getMessage());
        }
    } 

    private static function createTables($conn) {
        $conn->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin','client') DEFAULT 'client',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ");

        $conn->exec("
            CREATE TABLE IF NOT EXISTS tickets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                priority ENUM('low','medium','high') DEFAULT 'low',
                status ENUM('open','in_progress','resolved','cancelled') DEFAULT 'open',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB;
        ");

        $conn->exec("
            CREATE TABLE IF NOT EXISTS messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                ticket_id INT NOT NULL,
                user_id INT NOT NULL,
                message TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB;
        ");
    }

    private static function createDevAdminUser() {
        $conn = self::$connection;

        $email = 'teste@gmail.com';
        $name  = 'Usuário Teste';
        $senha = '$2y$12$nVxiEI1lTwd4G6h8sfpHzuJyeD7WhApT4lxKn9PHzkbnSNiU.2KNC'; // hash bcrypt
        $role  = 'admin';

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            return; // Já existe, não recria
        }

        $stmt = $conn->prepare("
            INSERT INTO users (name, email, password, role)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$name, $email, $senha, $role]);

        $id = $conn->lastInsertId();

        return [
            'id'    => $id,
            'login' => $email,
            'name'  => $name,
            'senha' => $senha,
            'role'  => $role
        ];
    }
}
?>