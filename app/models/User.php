<?php
class User {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function authenticate($login, $senha) {
        $stmt = $this->db->prepare('SELECT users.* FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['password'])) {
            return $user; // Autenticado com sucesso
        }

        return false;
    }
}
?>