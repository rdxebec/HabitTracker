<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1>📈 Analytics</h1>

    <?php

    $labels = [];
    $totals = [];
    $totalCompletions = 0;

    foreach ($monthlyData as $day) {

        $labels[] = $day['completed_date'];
        $totals[] = $day['total'];

        $totalCompletions += $day['total'];
    }

    $activeDays = count($monthlyData);

    $categories = [];
    $categoryTotals = [];

    foreach ($categoryStats as $item) {

        $categories[] = $item['category'];
        $categoryTotals[] = $item['total'];
    }

    ?>

    <div class="stats-grid">

        <div class="stat-card">
            <h3>Total Completions</h3>
            <p><?= $totalCompletions ?></p>
        </div>

        <div class="stat-card">
            <h3>Active Days</h3>
            <p><?= $activeDays ?></p>
        </div>

        <div class="stat-card">
            <h3>Average Per Day</h3>
            <p>
                <?= $activeDays > 0
                    ? round($totalCompletions / $activeDays, 1)
                    : 0 ?>
            </p>
        </div>

    </div>

    <div class="stats-grid">

        <div class="stat-card">

            <h3>🏆 Best Habit</h3>

            <?php if ($bestHabit): ?>

                <p>
                    <?= htmlspecialchars(
                        $bestHabit['title']
                    ) ?>
                </p>

                <small>
                    <?= $bestHabit['completions'] ?>
                    completions
                </small>

            <?php endif; ?>

        </div>

        <div class="stat-card">

            <h3>😴 Needs Work</h3>

            <?php if ($worstHabit): ?>

                <p>
                    <?= htmlspecialchars(
                        $worstHabit['title']
                    ) ?>
                </p>

                <small>
                    <?= $worstHabit['completions'] ?>
                    completions
                </small>

            <?php endif; ?>

        </div>

    </div>

    <div class="analytics-card">

        <h2>Monthly Activity</h2>

        <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
        </div>

    </div>

    <div class="analytics-card">

        <h2>📈 XP Growth</h2>

        <div class="chart-container">
            <canvas id="xpChart"></canvas>
        </div>

    </div>

    <div class="analytics-card">

        <h2>Category Distribution</h2>

        <div class="chart-container">
            <canvas id="categoryChart"></canvas>
        </div>

    </div>

    <?php

    $xpLabels = [];
    $xpTotals = [];

    foreach ($xpHistory as $row) {

        $xpLabels[] = $row['day'];
        $xpTotals[] = $row['total_xp'];
    }

    ?>

    <div class="analytics-card">

        <h2>🔥 Consistency Heatmap</h2>

        <div class="heatmap-grid">

            <?php
            $heatmap = [];

            foreach ($calendarData as $row) {
                $heatmap[$row['completed_date']] = $row['total'];
            }

            for ($i = 29; $i >= 0; $i--) {

                $date = date(
                    'Y-m-d',
                    strtotime("-$i days")
                );

                $count = $heatmap[$date] ?? 0;

                if ($count == 0) {
                    $class = 'heat-0';
                } elseif ($count <= 2) {
                    $class = 'heat-1';
                } elseif ($count <= 5) {
                    $class = 'heat-2';
                } else {
                    $class = 'heat-3';
                }
            ?>

                <a
                    href="/habittracker/public/analytics/day?date=<?= $date ?>"
                    class="heat-box <?= $class ?>"
                    title="<?= $date ?> (<?= $count ?> completions)">
                </a>

            <?php } ?>

        </div>

        <div class="analytics-card">

            <h2>🏆 Habit Leaderboard</h2>

            <table class="leaderboard-table">

                <thead>

                    <tr>
                        <th>Rank</th>
                        <th>Habit</th>
                        <th>Completions</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($topHabits as $index => $habit): ?>

                        <tr>

                            <td>

                                <?php
                                if ($index == 0) echo "🥇";
                                elseif ($index == 1) echo "🥈";
                                elseif ($index == 2) echo "🥉";
                                else echo "#" . ($index + 1);
                                ?>

                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $habit['title']
                                ) ?>
                            </td>

                            <td>
                                <?= $habit['completions'] ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx =
        document.getElementById(
            'monthlyChart'
        );

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: <?= json_encode($labels) ?>,

            datasets: [{

                label: 'Habit Completions',

                data: <?= json_encode($totals) ?>,

                backgroundColor: '#4f46e5',

                borderRadius: 8

            }]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                y: {
                    beginAtZero: true
                }

            }

        }

    });

    const pieCtx =
        document.getElementById(
            'categoryChart'
        );

    new Chart(pieCtx, {

        type: 'pie',

        data: {

            labels: <?= json_encode($categories) ?>,

            datasets: [{

                data: <?= json_encode($categoryTotals) ?>,

                backgroundColor: [
                    '#4f46e5',
                    '#22c55e',
                    '#f59e0b',
                    '#ef4444',
                    '#06b6d4',
                    '#8b5cf6'
                ]

            }]

        },

        options: {
            responsive: true,
            maintainAspectRatio: false
        }

    });

    const xpCtx =
        document.getElementById(
            'xpChart'
        );

    new Chart(xpCtx, {

        type: 'line',

        data: {

            labels: <?= json_encode($xpLabels) ?>,

            datasets: [{

                label: 'XP Earned',

                data: <?= json_encode($xpTotals) ?>,

                borderColor: '#22c55e',

                backgroundColor: '#22c55e',

                tension: 0.3

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false

        }

    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>