<?php require_once __DIR__ . '/layouts/header.php'; ?>

<div class="container">

    <h1>
        Welcome
        <?= htmlspecialchars($_SESSION['user_name']) ?>
        👋
    </h1>

    <p>
        Track your progress and stay consistent.
    </p>

    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-title">
                Total Habits
            </div>

            <div class="stat-value">
                <?= $totalHabits ?>
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-title">
                Completed Today
            </div>

            <div class="stat-value">
                <?= $completedToday ?>
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-title">
                Success Rate
            </div>

            <div class="stat-value">
                <?= $successRate ?>%
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-title">
                Active Streaks
            </div>

            <div class="stat-value">
                🔥 <?= $activeStreaks ?>
            </div>

        </div>

    </div>

    <div class="quick-actions">

        <h2>
            Quick Actions
        </h2>

        <div class="action-buttons">

            <a
            class="btn btn-primary"
            href="/habittracker/public/habits/create">
                Create Habit
            </a>

            <a
            class="btn btn-success"
            href="/habittracker/public/habits">
                Manage Habits
            </a>

        </div>

    </div>
    <div class="recent-card">

    <h2>
        Recent Habits
    </h2>

    <?php if(empty($recentHabits)): ?>

        <p>
            No habits created yet.
        </p>

    <?php else: ?>

        <ul class="recent-list">

            <?php foreach($recentHabits as $habit): ?>

                <li>

                    📚
                    <?= htmlspecialchars(
                        $habit['title']
                    ) ?>

                </li>

            <?php endforeach; ?>

        </ul>

    <?php endif; ?>

</div>

</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>