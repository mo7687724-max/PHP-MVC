<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/welcome');
    }

    public function login(): void
    {
        echo "<!DOCTYPE html><html><head><title>Login</title></head><body>";
        echo "<h2>Login Page</h2>";
        echo "<p>Authentication is required to access user management.</p>";
        echo "<form method='POST' action='/login'>";
        echo "<p>To simulate login for testing, click below:</p>";
        echo "<a href='?action=login_demo'>[Click here to simulate Login as Admin]</a>";
        echo "</form>";
        if (isset($_GET['action']) && $_GET['action'] === 'login_demo') {
            $_SESSION['user_id'] = 1;
            $this->redirect('/php-mvc/users');
        }
        echo "</body></html>";
    }
}

