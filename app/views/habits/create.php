<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <div class="form-card">

        <h1>Create Habit</h1>

        <br>

        <?php if (!empty($_SESSION['errors'])): ?>

            <div class="alert alert-danger">

                <?php foreach ($_SESSION['errors'] as $error): ?>

                    <p><?= htmlspecialchars($error) ?></p>

                <?php endforeach; ?>

            </div>

            <?php unset($_SESSION['errors']); ?>

        <?php endif; ?>

        <form
            action="/habittracker/public/habits/store"
            method="POST">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= $_SESSION['csrf_token']; ?>">

            <div class="form-group">

                <label>
                    Habit Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="<?= htmlspecialchars($_SESSION['old']['title'] ?? '') ?>"
                    required>

            </div>

            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea name="description"><?= htmlspecialchars($_SESSION['old']['description'] ?? '') ?></textarea>

            </div>

            <div class="form-group">

                <label>
                    Category
                </label>

                <input
                    type="text"
                    name="category"
                    value="<?= htmlspecialchars($_SESSION['old']['category'] ?? '') ?>">

            </div>

            <div class="form-group">

                <label>
                    Frequency
                </label>

                <select
                    name="frequency"
                    class="form-control">

                    <option value="daily"
                        <?= (($_SESSION['old']['frequency'] ?? '') == 'daily') ? 'selected' : '' ?>>Daily</option>

                    <option value="weekly"
                        <?= (($_SESSION['old']['frequency'] ?? '') == 'weekly') ? 'selected' : '' ?>>Weekly</option>

                    <option value="monthly"
                        <?= (($_SESSION['old']['frequency'] ?? '') == 'monthly') ? 'selected' : '' ?>>Monthly</option>

                </select>

            </div>

            <div class="form-group">

                <label>
                    Priority
                </label>

                <select
                    name="priority"
                    class="form-control">

                    <option value="low"
                        <?= (($_SESSION['old']['priority'] ?? '') == 'low') ? 'selected' : '' ?>>Low</option>

                    <option value="medium"
                        <?= (($_SESSION['old']['priority'] ?? '') == 'medium') ? 'selected' : '' ?>>Medium</option>

                    <option value="high"
                        <?= (($_SESSION['old']['priority'] ?? '') == 'high') ? 'selected' : '' ?>>High</option>

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                Save Habit

            </button>

        </form>

        <?php unset($_SESSION['old']); ?>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>