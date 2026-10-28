<?php
declare(strict_types=1);

$pageTitle = 'Services';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Our services</p>
        <h1>Discover your own kind of style.</h1>
        <p>Explore our fashion collections and styling services, with thoughtful options for everyday and special occasions.</p>
    </div>
</section>

<section class="section">
    <div class="container card-grid">
        <?php foreach ($services as $service): ?>
            <?= renderServiceCard($service) ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="cta">
    <div class="container cta-content">
        <div>
            <p class="eyebrow">Have a question?</p>
            <h2>Tell us what you're looking for.</h2>
        </div>
        <a class="button button-light" href="contact.php">Contact us</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
