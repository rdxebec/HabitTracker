<?php

class AuthController extends Controller
{
    public function register()
    {
        // Generate CSRF token
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->view('auth/register');
    }

   public function store()
{
    // CSRF Protection
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals(
            $_SESSION['csrf_token'],
            $_POST['csrf_token']
        )
    ) {
        die('Invalid CSRF Token');
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $errors = [];

    // Name validation
    if (empty($name)) {
        $errors[] = 'Name is required';
    }

    // Email validation
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address';
    }

    // Password validation
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match';
    }

    $userModel = new User();

    // Check email already exists
    if ($userModel->findByEmail($email)) {
        $errors[] = 'Email already registered';
    }

    if (!empty($errors)) {

        echo "<h2>Validation Errors</h2>";

        foreach ($errors as $error) {
            echo "<p>{$error}</p>";
        }

        exit;
    }

    // Hash Password
    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $userModel->create([
        'name' => htmlspecialchars($name),
        'email' => htmlspecialchars($email),
        'password' => $hashedPassword
    ]);

    echo "Registration Successful";
}
}