<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1>
        📅
        <?= htmlspecialchars($habit['title']) ?>
    </h1>

    <div class="history-stats">

        <div class="stat-card">
            <h3>🔥 Current Streak</h3>
            <p><?= $currentStreak ?> days</p>
        </div>

        <div class="stat-card">
            <h3>📈 Completion Rate</h3>
            <p><?= $completionRate ?>%</p>
        </div>

    </div>

    <div class="analytics-card">

        <h2>Completion History</h2>

        <?php

        $completedDates = [];

        foreach ($history as $entry) {
            $completedDates[] = $entry['completed_date'];
        }

        ?>

        <div class="heatmap-container">

            <div class="heatmap-header">
                <span>Mon</span>
                <span>Tue</span>
                <span>Wed</span>
                <span>Thu</span>
                <span>Fri</span>
                <span>Sat</span>
                <span>Sun</span>
            </div>

            <div class="heatmap-grid">

                <?php

                for ($i = 29; $i >= 0; $i--) {

                    $date = date(
                        'Y-m-d',
                        strtotime("-{$i} days")
                    );

                    $completed = in_array(
                        $date,
                        $completedDates
                    );

                ?>

                    <div
                        class="heatmap-cell <?= $completed ? 'active' : '' ?>"
                        title="<?= $date ?>">
                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>