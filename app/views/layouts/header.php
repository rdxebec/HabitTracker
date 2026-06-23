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

    <script>
        const toggle =
            document.getElementById(
                'theme-toggle'
            );

        if (
            localStorage.getItem('theme') ===
            'dark'
        ) {
            document.body.classList.add(
                'dark-mode'
            );
        }

        toggle?.addEventListener(
            'click',
            () => {

                document.body.classList.toggle(
                    'dark-mode'
                );

                localStorage.setItem(
                    'theme',
                    document.body.classList.contains(
                        'dark-mode'
                    ) ?
                    'dark' :
                    'light'
                );
            }
        );

        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    </script>