<?php
namespace App\Core;

abstract class Controller {
    protected function view($view, $data = []) {
        // Extract data to make variables available in view
        extract($data);
        
        // Get the view content
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} not found");
        }

        // Capture the view content
        ob_start();
        require_once $viewPath;
        $content = ob_get_clean();

        // Load the layout with the captured content
        require_once __DIR__ . "/../Views/layouts/main.php";
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }


    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function getPost($key = null) {
        if ($key) {
            return $_POST[$key] ?? null;
        }
        return $_POST;
    }

    protected function getQuery($key = null) {
        if ($key) {
            return $_GET[$key] ?? null;
        }
        return $_GET;
    }

    protected function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
}