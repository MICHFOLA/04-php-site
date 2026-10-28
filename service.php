<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

$slug = isset($_GET['slug']) && is_string($_GET['slug']) ? $_GET['slug'] : '';
$service = null;

foreach ($services as $serviceItem) {
    if ($serviceItem['slug'] === $slug) {
        $service = $serviceItem;
        break;
    }
}

if ($service === null) {
    http_response_code(404);
    $pageTitle = 'Service not found';
} else {
    $pageTitle = $service['title'];
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <?php if ($service === null): ?>
            <p class="eyebrow">Page not found</p>
            <h1>We couldn't find that service.</h1>
            <p>Please browse our current fashion and styling services.</p>
            <a class="button" href="services.php">Browse services</a>
        <?php else: ?>
            <p class="eyebrow">Folacrown Fashion House service</p>
            <h1><span aria-hidden="true"><?= e($service['icon']) ?></span> <?= e($service['title']) ?></h1>
            <p><?= e($service['description']) ?></p>
        <?php endif; ?>
    </div>
</section>

<?php if ($service !== null): ?>
    <section class="section">
        <div class="container content-narrow service-detail">
            <p class="eyebrow">Starting from</p>
            <p class="service-detail-price"><?= e(formatPrice($service['price'])) ?></p>
            <p>Contact us to discuss availability and details for this service. We'll be happy to help you find an option that suits your style.</p>
            <a class="button" href="contact.php">Ask us about this service</a>
        </div>
    </section>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
