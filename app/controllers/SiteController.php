<?php
require_once __DIR__ . '/../../config/config.php';
require_once APP_PATH . '/models/enums/Role.php';
require_once APP_PATH . '/models/Ticket.php';
require_once APP_PATH . '/models/enums/Priority.php';
require_once APP_PATH . '/models/enums/Status.php';

class SiteController {
    public function index() {
        if (!isset($_SESSION['login'])) {
            header('Location: /public/index.php?page=login');
            exit;
        }

        $logado = htmlspecialchars($_SESSION['login']);
       
        if ($this->isAdmin()) {
            require VIEW_PATH . '/site/admin.php';
        } else {
            require VIEW_PATH . '/site/client.php';
        }
    }

    public function findTikets($status, $priority) {
        global $db;
        $ticketModel = new Ticket($db);

        if (empty($status) && empty($priority)) {
            if ($this->isAdmin()) {
                return $ticketModel->findByFilters();
            }

            return $ticketModel->findByFilters(NULL, NULL, $_SESSION['user_id']);
        }

        if (empty($priority)) {
            if ($this->isAdmin()) {
                return $ticketModel->findByFilters(Status::{$status});
            }

            return $ticketModel->findByFilters(Status::{$status}, NULL, $_SESSION['user_id']);
        }

        if (empty($status)) {
            if ($this->isAdmin()) {
                return $ticketModel->findByFilters(NULL, Priority::{$priority});
            }

            return $ticketModel->findByFilters(NULL, Priority::{$priority}, $_SESSION['user_id']);
        }

        if ($this->isAdmin()) {
            return $ticketModel->findByFilters(Status::{$status}, Priority::{$priority});
        }

        return $ticketModel->findByFilters(Status::{$status}, Priority::{$priority}, $_SESSION['user_id']);
    }

    private function isAdmin() {
        $role = $_SESSION['role'];

        return $role == Role::admin->name;
    }
}
?>