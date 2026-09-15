<?php

class Authenticate implements MiddlewareInterface
{
    public function handle(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $baseDir = '/php-mvc';
            if (isset($_SERVER['SCRIPT_NAME'])) {
                $dir = dirname($_SERVER['SCRIPT_NAME']);
                $dir = preg_replace('#/public$#', '', $dir);
                if ($dir !== '' && $dir !== '/' && $dir !== '\\') {
                    $baseDir = $dir;
                }
            }

            header("Location: {$baseDir}/login");
            exit;
        }
    }
}

