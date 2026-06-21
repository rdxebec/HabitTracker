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

    $this->view('dashboard');
}
}