<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($tagline) ?>">
    <title><?= e($pageTitle) ?> | <?= e($siteName) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand" href="index.php">
                <span class="brand-name"><?= e($siteName) ?></span>
                <span class="brand-tagline"><?= e($tagline) ?></span>
            </a>
            <nav class="site-nav" aria-label="Main navigation">
                <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
                <?php $activePage = $currentPage === 'service.php' ? 'services.php' : $currentPage; ?>
                <?php foreach ($navItems as $label => $fileName): ?>
                    <?php $isCurrentPage = $activePage === $fileName; ?>
                    <a
                        href="<?= e($fileName) ?>"
                        class="<?= $isCurrentPage ? 'active' : '' ?>"
                        <?= $isCurrentPage ? 'aria-current="page"' : '' ?>
                    ><?= e($label) ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>
    <main>
