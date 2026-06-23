<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php if ($showLevelPopup): ?>

    <div class="level-popup">

        <div class="level-popup-content">

            <h1>🎉 LEVEL UP!</h1>

            <p>
                You reached Level
                <?= $user['level'] ?>
            </p>

            <button id="close-level-popup">
                Awesome!
            </button>

        </div>

    </div>

<?php endif; ?>

<div class="level-card">

    <h2>
        ⭐ Level <?= $currentLevel ?>
    </h2>

    <p>

        XP:
        <?= $levelXP ?>

        /

        <?= $neededXP ?>

    </p>

    <div class="xp-bar">

        <div
            class="xp-fill"
            style="
                width:
                <?= $progressPercent ?>%;
            ">
        </div>

    </div>

    <p>

        <?= $xpRemaining ?>

        XP until Level

        <?= $currentLevel + 1 ?>

    </p>

</div>

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

        <div class="stat-card">

            <div class="stat-title">
                Longest Streak
            </div>

            <div class="stat-value">
                🏆 <?= $longestStreak ?>
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-title">
                Weekly Progress
            </div>

            <div class="stat-value">
                📈 <?= $weeklyCompletions ?>
            </div>

        </div>


    </div>

    <div class="analytics-card">

        <h2>Level <?= $level ?></h2>

        <p><?= $xp ?> XP</p>

        <div class="xp-bar">

            <div
                class="xp-fill"
                style="width: <?= $xpProgress ?>%;"></div>

        </div>

        <small>
            <?= $xpProgress ?>/100 XP to next level
        </small>

    </div>

    <div class="challenge-widget">

        <h2>
            🔥 Today's Challenges
        </h2>

        <?php foreach (
            $dailyChallenges as $challenge
        ): ?>

            <div class="challenge-item">

                <strong>
                    <?= htmlspecialchars(
                        $challenge['title']
                    ) ?>
                </strong>

                <br>

                <small>
                    <?= htmlspecialchars(
                        $challenge['description']
                    ) ?>
                </small>

                <br>

                <?php if (
                    $userChallenges[$challenge['id']]
                ): ?>

                    <span class="challenge-complete">
                        ✅ Completed
                    </span>

                <?php else: ?>

                    <span class="challenge-pending">
                        ⏳ In Progress
                    </span>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

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

    <div class="achievement-card">

        <h2>
            🏆 Recent Achievements
        </h2>

        <?php if (empty($recentAchievements)): ?>

            <p>
                No achievements unlocked yet.
            </p>

        <?php else: ?>

            <ul class="achievement-list">

                <?php foreach (
                    $recentAchievements
                    as $achievement
                ): ?>

                    <li>

                    <li>
                        <?= $achievement['badge_icon'] ?>
                        <?= htmlspecialchars($achievement['name']) ?>
                    </li>

                    </li>

                <?php endforeach; ?>

            </ul>

        <?php endif; ?>

    </div>
    <div class="recent-card">

        <h2>
            Recent Habits
        </h2>

        <?php if (empty($recentHabits)): ?>

            <p>
                No habits created yet.
            </p>

        <?php else: ?>

            <ul class="recent-list">

                <?php foreach ($recentHabits as $habit): ?>

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

    <div class="analytics-card">

        <h2>Weekly Activity</h2>

        <?php if (empty($weeklyActivity)): ?>

            <p>No activity this week.</p>

        <?php else: ?>

            <?php foreach ($weeklyActivity as $day => $count): ?>

                <div class="activity-row">

                    <span>
                        <?= $day ?>
                    </span>

                    <strong>
                        <?= str_repeat('▓', $count) ?>
                        (<?= $count ?>)
                    </strong>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>
<script>
    const closeBtn =
        document.getElementById(
            'close-level-popup'
        );

    if (closeBtn) {

        closeBtn.addEventListener(
            'click',
            function() {

                fetch(
                        '/habittracker/public/dashboard/hideLevelPopup'
                    )
                    .then(() => {

                        document.querySelector(
                            '.level-popup'
                        ).style.display = 'none';

                    });

            }
        );

    }
</script>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>