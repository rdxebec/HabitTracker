<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>

<script>

const themeToggle =
    document.getElementById('theme-toggle');

if (themeToggle) {

    // Load saved theme
    if (
        localStorage.getItem('theme') === 'dark'
    ) {

        document.body.classList.add(
            'dark-mode'
        );

        themeToggle.innerHTML =
            '☀️ Light Mode';
    }

    themeToggle.addEventListener(
        'click',
        function () {

            document.body.classList.toggle(
                'dark-mode'
            );

            if (
                document.body.classList.contains(
                    'dark-mode'
                )
            ) {

                localStorage.setItem(
                    'theme',
                    'dark'
                );

                themeToggle.innerHTML =
                    '☀️ Light Mode';

            } else {

                localStorage.setItem(
                    'theme',
                    'light'
                );

                themeToggle.innerHTML =
                    '🌙 Dark Mode';
            }
        }
    );
}

</script>

</body>
</html>