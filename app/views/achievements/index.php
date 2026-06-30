<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <h1>🏆 Achievements</h1>

    <div class="achievement-grid">

        <?php

        $unlockedIds = array_column(
            $userAchievements,
            'id'
        );

        foreach ($allAchievements as $achievement):

            $unlocked = in_array(
                $achievement['id'],
                $unlockedIds
            );
        ?>

            <div class="achievement-card <?= $unlocked ? 'unlocked' : 'locked' ?>">

                <?php

                $current =
                    $achievementModel
                    ->getAchievementProgress(
                        $_SESSION['user_id'],
                        $achievement
                    );

                $target =
                    $achievement['target_value'];

                ?>

                <?php
                $displayCurrent = min($current, $target);
                ?>

                <p>
                    Progress:
                    <?= $displayCurrent ?>
                    /
                    <?= $target ?>
                </p>

                <div class="achievement-progress">
                    <div
                        class="achievement-progress-fill"
                        style="
                        width:
                            <?= min(
                                100,
                                ($target > 0)
                                    ? ($current / $target) * 100
                                    : 0
                            ) ?>%;
                            ">
                    </div>
                </div>

                <div class="icon">
                    <?= htmlspecialchars($achievement['badge_icon']) ?>
                </div>

                <h3>
                    <?= htmlspecialchars($achievement['name']) ?>
                </h3>

                <p>
                    <?= htmlspecialchars($achievement['description']) ?>
                </p>

                <?php if ($unlocked): ?>

                    <span class="status success">
                        ✅ Unlocked
                    </span>

                <?php else: ?>

                    <span class="status locked">
                        🔒 Locked
                    </span>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>