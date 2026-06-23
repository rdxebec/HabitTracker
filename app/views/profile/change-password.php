<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <div class="auth-card">

        <h1>🔒 Change Password</h1>

        <?php if (isset($_SESSION['error'])): ?>

            <div class="alert alert-danger">
                <?= $_SESSION['error']; ?>
            </div>

            <?php unset($_SESSION['error']); ?>

        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>

            <div class="alert alert-success">
                <?= $_SESSION['success']; ?>
            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>

        <form
            action="/habittracker/public/profile/password"
            method="POST">

            <div class="form-group">

                <label>Current Password</label>

                <input
                    type="password"
                    name="current_password"
                    required>

            </div>

            <div class="form-group">

                <label>New Password</label>

                <input
                    type="password"
                    name="new_password"
                    required>

            </div>

            <div class="form-group">

                <label>Confirm Password</label>

                <input
                    type="password"
                    name="confirm_password"
                    required>

            </div>

            <button
                type="submit"
                class="auth-btn">

                Update Password

            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>