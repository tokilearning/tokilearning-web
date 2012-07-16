<!-- Begin of error-number-section -->
<section id="error-number">
        <?php if (empty($error['code'])): ?>
                <h1>404</h1>
        <?php else: ?>
                <h1><?php echo $error['code']; ?></h1>
        <?php endif; ?>
</section>
<section id="error-text">
        <p><a class="button" href="dashboard.html">&laquo; Back to Dashboard</a></p>
</section>