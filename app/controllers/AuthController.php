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

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'name' => $name,
                'email' => $email
            ];

            header(
                'Location: /habittracker/public/register'
            );

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

        $_SESSION['success'] =
            'Registration successful. Please login.';
            
        unset($_SESSION['old']);

        header(
            'Location: /habittracker/public/login'
        );

        exit;
    }
    public function login()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] =
                bin2hex(random_bytes(32));
        }

        $this->view('auth/login');
    }

    public function authenticate()
    {
        // CSRF Validation
        if (
            !isset($_POST['csrf_token']) ||
            !hash_equals(
                $_SESSION['csrf_token'],
                $_POST['csrf_token']
            )
        ) {
            die('Invalid CSRF Token');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {

            $_SESSION['error'] =
                'Email and Password are required';

            header(
                'Location: /habittracker/public/login'
            );

            exit;
        }

        $userModel = new User();

        $user = $userModel->findByEmail($email);

        if (!$user) {

            $_SESSION['error'] =
                'Invalid Email or Password';

            header(
                'Location: /habittracker/public/login'
            );

            exit;
        }

        if (
            !password_verify(
                $password,
                $user['password']
            )
        ) {

            $_SESSION['error'] =
                'Invalid Email or Password';

            header(
                'Location: /habittracker/public/login'
            );

            exit;
        }

        // Prevent Session Fixation
        session_regenerate_id(true);

        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header('Location: /habittracker/public/dashboard');
        exit;
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header('Location: /habittracker/public/login');
        exit;
    }
}
