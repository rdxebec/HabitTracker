<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1>📚 Habit Templates</h1>

    <div class="achievement-grid">

        <?php foreach ($templates as $template): ?>

            <div class="achievement-card">

                <h3>
                    <?= htmlspecialchars(
                        $template['title']
                    ) ?>
                </h3>

                <p>
                    <?= htmlspecialchars(
                        $template['description']
                    ) ?>
                </p>

                <a
                    href="/habittracker/public/templates/use?id=<?= $template['id'] ?>"
                    class="btn-primary">

                    Use Template

                </a>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>