<?php

class AuthController extends Controller
{
    public function register()
    {
        if (isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/dashboard');
            exit;
        }

        // Prevent browser caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: 0");
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

        $errors = [];



        $name = trim($_POST['name'] ?? '');

        $name = preg_replace('/\s+/', ' ', trim($name));

        // Name validation
        // Name validation
        if ($name === '') {

            $errors[] = 'Name is required';
        } elseif (strlen($name) < 2) {

            $errors[] = 'Name must be at least 2 characters.';
        } elseif (strlen($name) > 50) {

            $errors[] = 'Name cannot exceed 50 characters.';
        } elseif (!preg_match("/^[a-zA-Z ]+$/", $name)) {

            $errors[] = 'Name may contain only letters and spaces.';
        }

        $email = strtolower(trim($_POST['email'] ?? ''));

        if (strlen($email) > 255) {
            $errors[] = "Email is too long.";
        }
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';



        // Email validation
        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address';
        }

        // Password validation
        if (strlen($password) < 8) {

            $errors[] = 'Password must be at least 8 characters';
        } elseif (strlen($password) > 72) {

            $errors[] = 'Password cannot exceed 72 characters';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }

        if (empty($errors)) {

            $userModel = new User();

            if ($userModel->findByEmail($email)) {

                $errors[] = 'Email already registered';
            }
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
            'name' => $name,
            'email' => $email,
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
        if (isset($_SESSION['logged_in'])) {
            header('Location: /habittracker/public/dashboard');
            exit;
        }
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

        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {

            $_SESSION['error'] =
                'Email and Password are required';

            $_SESSION['old_email'] = $email;

            header(
                'Location: /habittracker/public/login'
            );

            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $_SESSION['error'] = 'Invalid email format';

            $_SESSION['old_email'] = $email;

            header('Location: /habittracker/public/login');
            exit;
        }

        $userModel = new User();

        $user = $userModel->findByEmail($email);

        if (!$user) {

            $_SESSION['error'] =
                'Invalid Email or Password';

            $_SESSION['old_email'] = $email;

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

            $_SESSION['old_email'] = $email;

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

        unset($_SESSION['old_email']);

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
