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