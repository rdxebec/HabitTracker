<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Register | Habit Tracker</title>

    <link rel="stylesheet"
        href="/habittracker/public/assets/css/app.css">

    <link rel="stylesheet"
        href="/habittracker/public/assets/css/auth.css">

</head>

<body class="auth-page">

    <div class="auth-container">

        <div class="auth-left">

            <h1>🏆 Habit Tracker</h1>

            <p class="auth-tagline">
                Start your journey today.
                Build powerful habits, stay consistent,
                and become the best version of yourself.
            </p>

            <ul>

                <li>🔥 Build Daily Streaks</li>

                <li>🏅 Unlock Achievements</li>

                <li>📈 Track Your Progress</li>

                <li>⚡ Gain XP & Level Up</li>

            </ul>

        </div>

        <div class="auth-card">
            <?php if (!empty($_SESSION['errors'])): ?>

                <div class="error-box">

                    <?php foreach ($_SESSION['errors'] as $error): ?>

                        <p><?= htmlspecialchars($error) ?></p>

                    <?php endforeach; ?>

                </div>

                <?php unset($_SESSION['errors']); ?>

            <?php endif; ?>

            <h2>Create Account</h2>

            <form
                action="/habittracker/public/register"
                method="POST">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= $_SESSION['csrf_token']; ?>">

                <div class="form-group">

                    <label>Name</label>

                    <input
                        type="text"
                        name="name"
                        value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>"
                        required>

                </div>

                <div class="form-group">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                        required>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required>

                </div>

                <div class="form-group">

                    <label>Confirm Password</label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        required>

                </div>

                <div
                    style="margin-bottom:20px;">

                    <label>

                        <input
                            type="checkbox"
                            onclick="togglePasswords()">

                        Show Passwords

                    </label>

                </div>

                <button
                    type="submit"
                    class="auth-btn">

                    Create Account

                </button>

            </form>

            <p class="auth-footer">

                Already have an account?

                <a href="/habittracker/public/login">
                    Login
                </a>

            </p>

        </div>

    </div>

    <script>
        function togglePasswords() {
            const password =
                document.getElementById(
                    'password'
                );

            const confirmPassword =
                document.getElementById(
                    'confirm_password'
                );

            password.type =
                password.type === 'password' ?
                'text' :
                'password';

            confirmPassword.type =
                confirmPassword.type === 'password' ?
                'text' :
                'password';
        }
    </script>

</body>

</html>