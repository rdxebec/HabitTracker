<div class="container">

    <h1>🏆 My Achievements</h1>

    <?php if (empty($achievements)): ?>

        <p>No achievements unlocked yet.</p>

    <?php else: ?>

        <div class="achievement-grid">

            <?php foreach ($achievements as $achievement): ?>

                <div class="achievement-card">

                    <h3>
                        <?= htmlspecialchars($achievement['badge_icon']) ?>
                        <?= htmlspecialchars($achievement['name']) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars(
                            $achievement['description']
                        ) ?>
                    </p>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>