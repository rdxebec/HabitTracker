<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Habit Tracker</title>

    <link
        rel="stylesheet"
        href="/habittracker/public/assets/css/app.css">

    <link rel="stylesheet"
        href="/habittracker/public/assets/css/habits.css">

    <link
        rel="stylesheet"
        href="/habittracker/public/assets/css/achievements.css">

</head>

<body>

    <?php
    // Generate CSRF token once per session
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    ?>
    <?php if (
        isset(
            $_SESSION['achievement_notification']
        )
    ): ?>

        <div id="achievement-toast">

            <?= $_SESSION['achievement_notification'] ?>

        </div>

        <?php
        unset(
            $_SESSION['achievement_notification']
        );
        ?>

    <?php endif; ?>

    <?php require_once __DIR__ . '/navbar.php'; ?>
    <script>
        document.addEventListener(
            'DOMContentLoaded',
            () => {

                const toast =
                    document.getElementById(
                        'achievement-toast'
                    );

                if (toast) {

                    setTimeout(
                        () => {

                            toast.remove();

                        },
                        5000
                    );
                }
            }
        );
    </script>