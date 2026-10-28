<?php
declare(strict_types=1);

$pageTitle = 'Home';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="container hero-content">
        <p class="eyebrow">Style with a signature</p>
        <h1>Find the look that feels like you.</h1>
        <p class="hero-text">Discover considered fashion, standout occasion wear, and personal styling from Folacrown Fashion House.</p>
        <a class="button" href="services.php">Explore the collection</a>
    </div>
</section>

<section class="section">
    <div class="container intro-grid">
        <div>
            <p class="eyebrow">Welcome to Folacrown Fashion House</p>
            <h2>Confidence begins with what you wear.</h2>
        </div>
        <div>
            <p>From everyday wardrobe favourites to looks for life's biggest occasions, we make discovering your personal style feel special.</p>
            <a class="text-link" href="about.php">Discover our story <span aria-hidden="true">&rarr;</span></a>
        </div>
    </div>
</section>

<section class="section section-tint">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">What we do</p>
            <h2>Made for every moment.</h2>
        </div>
        <div class="card-grid">
            <article class="card">
                <span class="card-number">01</span>
                <h3>Signature collection</h3>
                <p>Explore thoughtfully selected pieces to bring personality to your everyday wardrobe.</p>
            </article>
            <article class="card">
                <span class="card-number">02</span>
                <h3>Occasion wear</h3>
                <p>Find a memorable look for celebrations, milestones, and special evenings.</p>
            </article>
            <article class="card">
                <span class="card-number">03</span>
                <h3>Personal styling</h3>
                <p>Get considered guidance to help you build a look that feels unmistakably yours.</p>
            </article>
        </div>
        <a class="text-link" href="services.php">Explore what we offer <span aria-hidden="true">&rarr;</span></a>
    </div>
</section>

<section class="cta">
    <div class="container cta-content">
        <div>
            <p class="eyebrow">Your next look starts here</p>
            <h2>Let's find something you'll love wearing.</h2>
        </div>
        <a class="button button-light" href="contact.php">Get in touch</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
