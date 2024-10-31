<?php

namespace App\components;

use App\Controllers\MainController;

class Main
{
    public function start()
    {
        session_start();
        
        // Generate CSRF token if it doesn't exist
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // Handle URL redirection to remove trailing slashes
        $this->handleTrailingSlash();

        // Verify CSRF token and sanitize POST data if request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest();
        }

        // Handle URL parameters for routing
        $params = $this->getUrlParameters();

        // Instantiate the appropriate controller and call the method
        $this->routeRequest($params);
    }

    private function handleTrailingSlash()
    {
        $uri = $_SERVER['REQUEST_URI'];
        
        if (!empty($uri) && $uri !== '/' && $uri[-1] === '/') {
            http_response_code(301);
            header('Location: ' . rtrim($uri, '/'));
            exit();
        }
    }

    private function handlePostRequest()
    {
        $csrfToken = $_POST['csrf_token'] ?? '';
        $this->checkCsrfToken($csrfToken);
        $_POST = $this->sanitizeFormData($_POST);
    }

    private function getUrlParameters()
    {
        return isset($_GET['p']) ? explode('/', filter_var($_GET['p'], FILTER_SANITIZE_URL)) : [];
    }

    private function routeRequest(array $params)
    {
        if (isset($params[0]) && $params[0] !== '') {
            $controllerName = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
            
            if (!class_exists($controllerName)) {
                $this->error404("Controller not found.");
            }

            $controller = new $controllerName();
            $action = array_shift($params) ?: 'index';

            if (method_exists($controller, $action)) {
                call_user_func_array([$controller, $action], $params);
            } else {
                $this->error404("The requested page does not exist.");
            }
        } else {
            // Default controller and action
            $controller = new MainController();
            $controller->index();
        }
    }

    private function checkCsrfToken($token)
    {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            http_response_code(403);
            echo "Invalid CSRF Token.";
            exit();
        }
    }

    private function sanitizeFormData(array $data)
    {
        return array_map(function ($value) {
            return is_array($value) ? $this->sanitizeFormData($value) : (is_string($value) ? strip_tags($value) : $value);
        }, $data);
    }

    private function error404($message)
    {
        http_response_code(404);
        echo $message;
        exit();
    }
}
