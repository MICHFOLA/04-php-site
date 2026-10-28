<?php

$pageTitle = 'Contact';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Contact us</p>
        <h1>Let's find your next favourite look.</h1>
        <p>Ask us about the collection, occasion wear, or a personal styling visit.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <div>
            <h2>We'd love to hear from you.</h2>
            <p>For questions about our pieces or styling, send us an email and our team will be happy to help.</p>
            <a class="contact-email" href="mailto:<?= htmlspecialchars($contactEmail, ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($contactEmail, ENT_QUOTES, 'UTF-8') ?>
            </a>
        </div>
        <aside class="contact-note">
            <h3>How can we help?</h3>
            <p>Tell us what you're shopping for, the occasion you're dressing for, or if you'd like to arrange styling guidance. We'll help you find the right next step.</p>
        </aside>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
