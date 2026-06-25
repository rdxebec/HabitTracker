<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <div class="profile-layout">

        <aside class="profile-sidebar">

            <h3>⚙️ Account</h3>

            <a href="/habittracker/public/profile">
                👤 Profile
            </a>
            <a href="/habittracker/public/profile/password">
                🔒 Change Password
            </a>

            <button class="theme-toggle">
                🌙 Dark Mode
            </button>

            <a href="/habittracker/public/logout">
                🚪 Logout
            </a>

        </aside>

        <div class="profile-content">

            <h1>👤 Profile</h1>
            <div class="dashboard-grid">

                <div class="stat-card">
                    <h3>Name</h3>
                    <h2>
                        <?= htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') ?>
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

            <div class="profile-achievements">

                <h2>🏆 Achievements</h2>

                <?php if (empty($recentAchievements)): ?>

                    <p>No achievements unlocked yet.</p>

                <?php else: ?>

                    <div class="achievement-grid">

                        <?php foreach ($recentAchievements as $achievement): ?>

                            <div class="achievement-card">

                                <div class="achievement-icon">
                                    <?= $achievement['badge_icon'] ?>
                                </div>

                                <h3>
                                    <?= htmlspecialchars($achievement['name']) ?>
                                </h3>

                                <p>
                                    <?= htmlspecialchars($achievement['description']) ?>
                                </p>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>