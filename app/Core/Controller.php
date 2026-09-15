<?php

class Controller
{
    protected function view(
        string $view,
        array $data = []
    ): void {
        $viewPath = __DIR__ .
            '/../../resources/views/' .
            $view .
            '.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "View not found: " . $view;
            return;
        }

        extract($data);

        require $viewPath;
    }

    protected function redirect(string $url): void
    {
        if (isset($_SERVER['SCRIPT_NAME'])) {
            $baseDir = dirname($_SERVER['SCRIPT_NAME']);
            $baseDir = preg_replace('#/public$#', '', $baseDir);
            if ($baseDir !== '' && $baseDir !== '/' && str_starts_with($url, '/php-mvc')) {
                $url = $baseDir . substr($url, strlen('/php-mvc'));
            }
        }

        header("Location: $url");
        exit;
    }
}
