<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1>🏆 Challenges</h1>

    <div class="challenge-grid">

        <?php foreach ($challenges as $challenge): ?>

            <div class="challenge-card">

                <h3>
                    <?= htmlspecialchars(
                        $challenge['title']
                    ) ?>
                </h3>

                <p>
                    <?= htmlspecialchars(
                        $challenge['description']
                    ) ?>
                </p>

                <p>
                    🎯 Target:
                    <?= $challenge['target_value'] ?>
                </p>

                <p>
                    ⭐ <?= $challenge['xp_reward'] ?>
                    XP
                </p>

                <?php if (
                    isset(
                        $joined[$challenge['id']]
                    )
                ): ?>

                    <?php if (
                        $joined[$challenge['id']]
                    ): ?>

                        <span class="completed-badge">
                            ✅ Completed
                        </span>

                    <?php else: ?>

                        <span class="joined-badge">
                            🔥 In Progress
                        </span>

                    <?php endif; ?>

                <?php else: ?>

                    <a
                        href="/habittracker/public/challenges/join?id=<?= $challenge['id'] ?>"
                        class="btn btn-primary">
                        Join Challenge
                    </a>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>