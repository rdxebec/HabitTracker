<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Habit Tracker</title>
    <link rel="stylesheet"
        href="/habittracker/public/assets/css/app.css">

    <link rel="stylesheet"
        href="/habittracker/public/assets/css/auth.css">
</head>

<body class="auth-page">
    <div class="auth-card">
        <h1>Create Account</h1>

        <form action="/habittracker/public/register"
            method="POST">
            <input
                type="hidden"
                name="csrf_token"
                value="<?= $_SESSION['csrf_token']; ?>">

            <div class="form-group">
                <label>Name</label>
                <input type="text"
                    name="name"
                    required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email"
                    name="email"
                    required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password"
                    name="password"
                    required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password"
                    name="confirm_password"
                    required>
            </div>

            <button type="submit" class="auth-btn">
                Register
            </button>

        </form>

    </div>

</body>

</html>