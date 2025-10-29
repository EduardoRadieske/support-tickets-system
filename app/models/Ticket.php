<?php
require_once 'enums/Status.php';
require_once 'enums/Priority.php';

class Ticket {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByFilters($status = NULL, $priority = NULL, $user_id = NULL) {
        $sql = 'SELECT tickets.* FROM tickets WHERE tickets.id > 0 ';
        $params = [];
        if (isset($user_id) && !empty($user_id)) {
            $sql = $sql . ' AND user_id = ? ';
            array_push($params, $user_id);
        }

        if (isset($status) && !empty($status)) {
            $sql = $sql . ' AND status = ? ';
            array_push($params, $status->name);
        }

        if (isset($priority) && !empty($priority)) {
            $sql = $sql . ' AND priority = ? ';
            array_push($params, $priority->name);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>