<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function formatPrice(float $amount): string
{
    return '₦' . number_format($amount, 2);
}

/**
 * @param array{slug: string, title: string, description: string, price: float, icon: string} $service
 */
function renderServiceCard(array $service): string
{
    $url = 'service.php?slug=' . rawurlencode($service['slug']);

    return '<article class="card service-card">'
        . '<span class="service-icon" aria-hidden="true">' . e($service['icon']) . '</span>'
        . '<h2><a href="' . e($url) . '">' . e($service['title']) . '</a></h2>'
        . '<p>' . e($service['description']) . '</p>'
        . '<p class="service-price">' . e(formatPrice($service['price'])) . '</p>'
        . '<a class="text-link" href="' . e($url) . '">View details <span aria-hidden="true">&rarr;</span></a>'
        . '</article>';
}
