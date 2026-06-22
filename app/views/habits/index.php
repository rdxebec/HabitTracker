<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1 class="page-title">My Habits</h1>
    <form method="GET" action="/habittracker/public/habits" class="filter-form">

        <input
            type="text"
            name="search"
            placeholder="Search habits..."
            value="<?= $_GET['search'] ?? '' ?>">

        <select name="priority">
            <option value="">All Priorities</option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
        </select>

        <select name="category">
            <option value="">All Categories</option>
            <option value="Fitness">Fitness</option>
            <option value="Learning">Learning</option>
            <option value="Health">Health</option>
            <option value="Productivity">Productivity</option>
            <option value="Gratitude">Gratitude</option>
        </select>

        <select name="frequency">
            <option value="">All Frequencies</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
        </select>

        <button type="submit" class="btn btn-primary">
            Filter
        </button>

    </form>

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

                        <a
                            href="/habittracker/public/habits/history?id=<?= $habit['id'] ?>"
                            class="btn">
                            History
                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>