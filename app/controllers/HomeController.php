<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home');
    }

    public function dashboard()
    {
        if (
            !isset($_SESSION['logged_in']) ||
            $_SESSION['logged_in'] !== true
        ) {
            header('Location: /habittracker/public/login');
            exit;
        }

        // Prevent browser caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: 0");

        $this->view('dashboard');
    }
}
