<?php
declare(strict_types=1);

$pageTitle = 'About';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">About us</p>
        <h1>Fashion with feeling and individuality.</h1>
        <p>We believe what you wear can be a joyful expression of who you are.</p>
    </div>
</section>

<section class="section">
    <div class="container content-narrow">
        <h2>A fashion house with a personal touch.</h2>
        <p>Folacrown Fashion House brings together distinctive pieces, thoughtful service, and a love of personal style. We help each customer find fashion that feels expressive, comfortable, and their own.</p>
        <p>Whether you're refreshing your wardrobe or searching for an outfit for a special occasion, our aim is to make the experience welcoming, inspiring, and all about you.</p>
        <div class="values-grid">
            <article class="value">
                <h3>Individuality</h3>
                <p>Style should celebrate what makes you uniquely you.</p>
            </article>
            <article class="value">
                <h3>Quality</h3>
                <p>We value considered details and pieces chosen with care.</p>
            </article>
            <article class="value">
                <h3>Personal service</h3>
                <p>A warm, thoughtful experience from first look to final choice.</p>
            </article>
        </div>
        <section class="team-section" aria-labelledby="team-heading">
            <div class="section-heading">
                <p class="eyebrow">Meet the team</p>
                <h2 id="team-heading">The people behind Folacrown.</h2>
            </div>
            <div class="team-grid">
                <?php foreach ($team as $member): ?>
                    <article class="team-card">
                        <h3><?= e($member['name']) ?></h3>
                        <p class="team-role"><?= e($member['role']) ?></p>
                        <p><?= e($member['bio']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
