<?php
// ============================================================
// Router — Aurora Cafe
// ============================================================

class Router
{
    private array $routes = [];

    public function get(string $path, string $controller, string $method): void
    {
        $this->routes['GET'][$path] = [$controller, $method];
    }

    public function post(string $path, string $controller, string $method): void
    {
        $this->routes['POST'][$path] = [$controller, $method];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        // URL-decode trước khi xử lý (BASE_URL có dấu cách/ký tự đặc biệt)
        $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        // Strip base path
        $basePath = ROUTE_BASE_PATH;
        if ($basePath !== '' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }
        $uri = '/' . trim($uri, '/');
        if ($uri === '')
            $uri = '/';

        if (isset($this->routes[$method][$uri])) {
            [$controllerName, $action] = $this->routes[$method][$uri];
            $controllerFile = BASE_PATH . "/controllers/{$controllerName}.php";
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $controllerName();
                $controller->$action();
                return;
            }
            // Controller file chưa tạo — tạm thời báo lỗi rõ ràng
            http_response_code(500);
            echo "<h2 style='font-family:monospace;padding:2rem'>Controller chưa được tạo: <code>{$controllerName}.php</code></h2>";
            return;
        }

        // 404
        http_response_code(404);
        $view404 = BASE_PATH . '/views/404.php';
        if (file_exists($view404)) {
            require_once $view404;
        } else {
            echo "<h2 style='font-family:monospace;padding:2rem'>404 — Trang không tìm thấy: <code>{$uri}</code></h2>";
        }
    }
}
