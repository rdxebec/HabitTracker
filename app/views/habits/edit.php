<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <div class="form-card">

        <h1>Edit Habit</h1>

        <br>

        <form
            action="/habittracker/public/habits/update"
            method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $habit['id'] ?>">

            <div class="form-group">

                <label>
                    Habit Title
                </label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="<?= htmlspecialchars($habit['title']) ?>"
                    required>

            </div>

            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    class="form-control"><?= htmlspecialchars($habit['description']) ?></textarea>

            </div>

            <div class="form-group">

                <label>
                    Category
                </label>

                <input
                    type="text"
                    name="category"
                    class="form-control"
                    value="<?= htmlspecialchars($habit['category']) ?>">

            </div>

            <div class="form-group">

                <label>
                    Frequency
                </label>

                <select
                    name="frequency"
                    class="form-control">

                    <option value="daily"
                        <?= $habit['frequency'] == 'daily' ? 'selected' : '' ?>>
                        Daily
                    </option>

                    <option value="weekly"
                        <?= $habit['frequency'] == 'weekly' ? 'selected' : '' ?>>
                        Weekly
                    </option>

                    <option value="monthly"
                        <?= $habit['frequency'] == 'monthly' ? 'selected' : '' ?>>
                        Monthly
                    </option>

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
                        <?= $habit['priority'] == 'low' ? 'selected' : '' ?>>
                        Low
                    </option>

                    <option value="medium"
                        <?= $habit['priority'] == 'medium' ? 'selected' : '' ?>>
                        Medium
                    </option>

                    <option value="high"
                        <?= $habit['priority'] == 'high' ? 'selected' : '' ?>>
                        High
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                Update Habit

            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>