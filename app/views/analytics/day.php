<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1>
        📅 Activity for
        <?= htmlspecialchars($date) ?>
    </h1>

    <?php if (empty($habits)): ?>

        <div class="card">
            <p>No habits completed.</p>
        </div>

    <?php else: ?>

        <div class="habit-grid">

            <?php foreach ($habits as $habit): ?>

                <div class="habit-card">

                    <h3>
                        <?= htmlspecialchars(
                            $habit['title']
                        ) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars(
                            $habit['category']
                        ) ?>
                    </p>

                    <p>
                        ✅ Completed
                    </p>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>