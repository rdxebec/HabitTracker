<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1>👤 Profile</h1>

    <div class="dashboard-grid">

        <div class="stat-card">
            <h3>Name</h3>
            <h2>
                <?= htmlspecialchars(
                    $user['name']
                ) ?>
            </h2>
        </div>

        <div class="stat-card">
            <h3>Level</h3>
            <h2>
                <?= $user['level'] ?>
            </h2>
        </div>

        <div class="stat-card">
            <h3>XP</h3>
            <h2>
                <?= $user['xp'] ?>
            </h2>
        </div>

        <div class="stat-card">
            <h3>Achievements</h3>
            <h2>
                <?= $achievements ?>
            </h2>
        </div>

        <div class="stat-card">
            <h3>Total Habits</h3>
            <h2>
                <?= $totalHabits ?>
            </h2>
        </div>

        <div class="stat-card">
            <h3>Total Completions</h3>
            <h2>
                <?= $totalCompletions ?>
            </h2>
        </div>

        <div class="stat-card">
            <h3>Longest Streak</h3>
            <h2>
                🔥 <?= $longestStreak ?>
            </h2>
        </div>

        <div class="stat-card">
            <h3>Member Since</h3>
            <h2>
                <?= date(
                    'd M Y',
                    strtotime(
                        $user['created_at']
                    )
                ) ?>
            </h2>
        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>