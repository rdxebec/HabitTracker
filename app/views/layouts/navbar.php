<nav class="navbar">

    <div class="logo">
        Habit Tracker
    </div>

    <?php if (isset($_SESSION['logged_in'])): ?>

        <div class="nav-links">

            <?php
            $currentPage = $_SERVER['REQUEST_URI'];
            ?>

            <a href="/habittracker/public/profile">
                Profile
            </a>

            <a
                class="<?= strpos($currentPage, '/dashboard') !== false ? 'active' : '' ?>"
                href="/habittracker/public/dashboard">
                Dashboard
            </a>

            <a href="/habittracker/public/challenges">
                Challenges
            </a>

            <a
                class="<?= strpos($currentPage, '/habits') !== false ? 'active' : '' ?>"
                href="/habittracker/public/habits">
                Habits
            </a>

            <li>
                <a href="/habittracker/public/achievements">
                    Achievements
                </a>
            </li>
            <li>
                <a href="/habittracker/public/templates">
                    Templates
                </a>
            </li>

            <a href="/habittracker/public/analytics">
                Analytics
            </a>

            <button class="theme-toggle theme-btn"></button>

            <a href="/habittracker/public/logout">
                Logout
            </a>

        </div>

    <?php endif; ?>

</nav>