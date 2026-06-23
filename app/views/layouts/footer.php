<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const buttons =
            document.querySelectorAll('.theme-toggle');

        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }

        buttons.forEach(btn => {

            btn.innerHTML =
                document.body.classList.contains('dark-mode') ?
                '☀️' :
                '🌙';

            btn.addEventListener('click', () => {

                document.body.classList.toggle('dark-mode');

                const dark =
                    document.body.classList.contains('dark-mode');

                localStorage.setItem(
                    'theme',
                    dark ? 'dark' : 'light'
                );

                buttons.forEach(button => {
                    button.innerHTML =
                        dark ? '☀️' : '🌙';
                });
            });
        });
    });
</script>

</body>

</html>