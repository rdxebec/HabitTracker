<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1 class="page-title">My Habits</h1>

    <a
        class="btn btn-primary"
        href="/habittracker/public/habits/create">
        Create Habit
    </a>

    <?php if (empty($habits)): ?>

        <p style="margin-top:20px;">No habits found.</p>

    <?php else: ?>

        <?php $logModel = new HabitLog(); ?>

        <div class="habits-grid">

            <?php foreach ($habits as $habit): ?>

                <div class="habit-card">

                    <div class="habit-title">
                        <?= htmlspecialchars($habit['title']) ?>
                    </div>

                    <p>
                        <?= htmlspecialchars($habit['description']) ?>
                    </p>

                    <div class="habit-meta">
                        Frequency:
                        <?= htmlspecialchars($habit['frequency']) ?>
                    </div>

                    <p>
                        🔥 Current Streak:
                        <?= $logModel->getCurrentStreak($habit['id']) ?>
                        day(s)
                    </p>

                    <?php if ($logModel->isCompletedToday($habit['id'])): ?>

                        <p>✅ Completed Today</p>

                    <?php else: ?>

                        <p>❌ Not Completed</p>

                        <a
                            class="btn btn-success"
                            href="/habittracker/public/habits/complete?id=<?= $habit['id'] ?>">
                            Complete Today
                        </a>

                    <?php endif; ?>

                    <div class="actions">

                        <a
                            class="btn btn-primary"
                            href="/habittracker/public/habits/edit?id=<?= $habit['id'] ?>">
                            Edit
                        </a>

                        <a
                            class="btn btn-danger"
                            href="/habittracker/public/habits/delete?id=<?= $habit['id'] ?>"
                            onclick="return confirm('Delete this habit?')">
                            Delete
                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>