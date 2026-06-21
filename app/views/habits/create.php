<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">

    <div class="form-card">

        <h1>Create Habit</h1>

        <br>

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
                    class="form-control"
                    placeholder="Example: Read 20 Pages"
                    required>

            </div>

            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    placeholder="Describe your habit..."></textarea>

            </div>

            <div class="form-group">

                <label>
                    Category
                </label>

                <input
                    type="text"
                    name="category"
                    class="form-control"
                    placeholder="Learning, Fitness, Health">

            </div>

            <div class="form-group">

                <label>
                    Frequency
                </label>

                <select
                    name="frequency"
                    class="form-control">

                    <option value="daily">
                        Daily
                    </option>

                    <option value="weekly">
                        Weekly
                    </option>

                    <option value="monthly">
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

                    <option value="low">
                        Low
                    </option>

                    <option value="medium">
                        Medium
                    </option>

                    <option value="high">
                        High
                    </option>

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                Save Habit

            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>