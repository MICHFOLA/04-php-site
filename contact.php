<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

$pageTitle = 'Contact';
$errors = [];
$submissionError = '';
$formValues = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'service' => '',
    'message' => '',
];

if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($formValues as $field => $defaultValue) {
        $postedValue = $_POST[$field] ?? '';
        $formValues[$field] = is_string($postedValue) ? trim($postedValue) : '';
    }

    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals($csrfToken, $submittedToken)) {
        $errors['csrf'] = 'Your form session expired. Please review the form and submit it again.';
    }
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $csrfToken = $_SESSION['csrf_token'];

    if ($formValues['name'] === '') {
        $errors['name'] = 'Please enter your name.';
    }

    if ($formValues['email'] === '') {
        $errors['email'] = 'Please enter your email address.';
    } elseif (filter_var($formValues['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if ($formValues['service'] === '') {
        $errors['service'] = 'Please choose a service.';
    } elseif (!in_array($formValues['service'], array_column($services, 'slug'), true)) {
        $errors['service'] = 'Please choose a valid service.';
    }

    $messageCharacterCount = preg_match_all('/./us', $formValues['message']);
    if ($formValues['message'] === '') {
        $errors['message'] = 'Please enter a message.';
    } elseif ($messageCharacterCount === false) {
        $errors['message'] = 'Please enter a message using valid text.';
    } elseif ($messageCharacterCount < 10 || $messageCharacterCount > 1000) {
        $errors['message'] = 'Your message must be between 10 and 1000 characters.';
    }

    foreach (['name', 'email', 'phone', 'service', 'message'] as $field) {
        if (preg_match('//u', $formValues[$field]) !== 1) {
            $errors[$field] = 'Please enter valid text.';
        }
    }

    if ($errors === []) {
        $selectedService = null;
        foreach ($services as $serviceItem) {
            if ($serviceItem['slug'] === $formValues['service']) {
                $selectedService = $serviceItem;
                break;
            }
        }

        if ($selectedService === null) {
            $errors['service'] = 'Please choose a valid service.';
        } else {
            $storageDirectory = __DIR__ . '/storage';
            $storageFile = $storageDirectory . '/messages.jsonl';

            if (!is_dir($storageDirectory)
                && !mkdir($storageDirectory, 0750, true)
                && !is_dir($storageDirectory)) {
                error_log('Unable to create the contact form storage directory.');
                $submissionError = 'We could not save your message right now. Please try again later.';
                http_response_code(500);
            } else {
                $submission = [
                    'timestamp' => date(DATE_ATOM),
                    'name' => $formValues['name'],
                    'email' => $formValues['email'],
                    'phone' => $formValues['phone'],
                    'service' => $selectedService['slug'],
                    'service_title' => $selectedService['title'],
                    'message' => $formValues['message'],
                ];
                $jsonLine = json_encode(
                    $submission,
                    JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
                );

                if ($jsonLine === false
                    || file_put_contents($storageFile, $jsonLine . PHP_EOL, FILE_APPEND | LOCK_EX) === false) {
                    error_log('Unable to append a contact form submission to the storage file.');
                    $submissionError = 'We could not save your message right now. Please try again later.';
                    http_response_code(500);
                } else {
                    header('Location: contact.php?sent=1', true, 303);
                    exit;
                }
            }
        }
    }
}

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
            <p>For questions about our pieces or styling, send us a message and our team will be happy to help.</p>
            <a class="contact-email" href="mailto:<?= e($contactEmail) ?>">
                <?= e($contactEmail) ?>
            </a>
            <aside class="contact-note">
                <h3>How can we help?</h3>
                <p>Tell us what you're shopping for, the occasion you're dressing for, or if you'd like to arrange styling guidance. We'll help you find the right next step.</p>
            </aside>
        </div>

        <div class="contact-form-panel">
            <?php if (isset($_GET['sent']) && $_GET['sent'] === '1'): ?>
                <p class="form-alert form-alert-success" role="status">Thanks for reaching out. Your message has been received.</p>
            <?php endif; ?>

            <?php if ($submissionError !== ''): ?>
                <p class="form-alert form-alert-error" role="alert"><?= e($submissionError) ?></p>
            <?php endif; ?>

            <?php if (isset($errors['csrf'])): ?>
                <p class="form-alert form-alert-error" role="alert"><?= e($errors['csrf']) ?></p>
            <?php endif; ?>

            <form action="contact.php" method="post" class="contact-form">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                <div class="form-field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required value="<?= e($formValues['name']) ?>"<?= isset($errors['name']) ? ' aria-invalid="true" aria-describedby="name-error"' : '' ?>>
                    <?php if (isset($errors['name'])): ?>
                        <p class="field-error" id="name-error"><?= e($errors['name']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="<?= e($formValues['email']) ?>"<?= isset($errors['email']) ? ' aria-invalid="true" aria-describedby="email-error"' : '' ?>>
                    <?php if (isset($errors['email'])): ?>
                        <p class="field-error" id="email-error"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="phone">Phone <span class="optional">(optional)</span></label>
                    <input id="phone" name="phone" type="tel" autocomplete="tel" value="<?= e($formValues['phone']) ?>"<?= isset($errors['phone']) ? ' aria-invalid="true" aria-describedby="phone-error"' : '' ?>>
                    <?php if (isset($errors['phone'])): ?>
                        <p class="field-error" id="phone-error"><?= e($errors['phone']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="service">Service</label>
                    <select id="service" name="service" required<?= isset($errors['service']) ? ' aria-invalid="true" aria-describedby="service-error"' : '' ?>>
                        <option value="">Choose a service</option>
                        <?php foreach ($services as $serviceItem): ?>
                            <option value="<?= e($serviceItem['slug']) ?>"<?= $formValues['service'] === $serviceItem['slug'] ? ' selected' : '' ?>><?= e($serviceItem['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['service'])): ?>
                        <p class="field-error" id="service-error"><?= e($errors['service']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-field">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" required<?= isset($errors['message']) ? ' aria-invalid="true" aria-describedby="message-error"' : '' ?>><?= e($formValues['message']) ?></textarea>
                    <?php if (isset($errors['message'])): ?>
                        <p class="field-error" id="message-error"><?= e($errors['message']) ?></p>
                    <?php endif; ?>
                </div>

                <button class="button" type="submit">Send message</button>
            </form>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
