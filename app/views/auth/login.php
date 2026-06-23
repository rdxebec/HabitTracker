<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Login | Habit Tracker</title>

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
                Build better habits.
                Stay consistent.
                Become your best self.
            </p>

            <ul>

                <li>🔥 Track Daily Streaks</li>

                <li>🏅 Unlock Achievements</li>

                <li>📈 View Analytics</li>

                <li>⚡ Gain XP & Level Up</li>

            </ul>

        </div>

        <div class="auth-card">

            <h2>Welcome Back</h2>
            <?php if (isset($_SESSION['error'])): ?>

                <div class="error-message">

                    <?= $_SESSION['error']; ?>

                </div>

                <?php unset($_SESSION['error']); ?>

            <?php endif; ?>

            <form
                action="/habittracker/public/login"
                method="POST">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= $_SESSION['csrf_token']; ?>">

                <div class="form-group">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        required>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        required>

                </div>

                <button
                    type="submit"
                    class="auth-btn">

                    Login

                </button>

            </form>

            <p class="auth-footer">

                Don't have an account?

                <a href="/habittracker/public/register">
                    Register
                </a>

            </p>

        </div>

    </div>

</body>

</html>