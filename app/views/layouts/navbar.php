<nav class="navbar">

    <div class="logo">
        Habit Tracker
    </div>

    <?php if(isset($_SESSION['logged_in'])): ?>

        <div class="nav-links">

            <?php
                $currentPage = $_SERVER['REQUEST_URI'];
            ?>

            <a
                class="<?= strpos($currentPage, '/dashboard') !== false ? 'active' : '' ?>"
                href="/habittracker/public/dashboard">
                Dashboard
            </a>

            <a
                class="<?= strpos($currentPage, '/habits') !== false ? 'active' : '' ?>"
                href="/habittracker/public/habits">
                Habits
            </a>

            <a href="/habittracker/public/logout">
                Logout
            </a>

        </div>

    <?php endif; ?>

</nav>