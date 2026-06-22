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

    <div class="analytics-card">

        <h2>Monthly Activity</h2>

        <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
        </div>

    </div>

    <div class="analytics-card">

        <h2>Category Distribution</h2>

        <div class="chart-container">
            <canvas id="categoryChart"></canvas>
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
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>