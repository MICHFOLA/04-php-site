<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Messages';
$loginError = '';
$isAuthenticated = ($_SESSION['messages_authenticated'] ?? false) === true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$isAuthenticated) {
    $submittedPassword = $_POST['password'] ?? '';

    if (is_string($submittedPassword) && hash_equals($messagesPassword, $submittedPassword)) {
        session_regenerate_id(true);
        $_SESSION['messages_authenticated'] = true;
        header('Location: messages.php', true, 303);
        exit;
    }

    $loginError = 'That password was not correct. Please try again.';
}

$messages = [];
$storageError = '';

if ($isAuthenticated) {
    $messagesFile = __DIR__ . '/storage/messages.jsonl';

    if (is_file($messagesFile)) {
        $lines = file($messagesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            error_log('Unable to read the contact messages file.');
            $storageError = 'Messages could not be loaded. Check the storage file permissions.';
        } else {
            foreach ($lines as $lineNumber => $line) {
                $message = json_decode($line, true);

                if (!is_array($message)) {
                    error_log('Skipping invalid JSON in contact messages file at line ' . ($lineNumber + 1) . '.');
                    continue;
                }

                $messages[] = [
                    'timestamp' => is_string($message['timestamp'] ?? null) ? $message['timestamp'] : '',
                    'name' => is_string($message['name'] ?? null) ? $message['name'] : '',
                    'email' => is_string($message['email'] ?? null) ? $message['email'] : '',
                    'phone' => is_string($message['phone'] ?? null) ? $message['phone'] : '',
                    'service_title' => is_string($message['service_title'] ?? null) ? $message['service_title'] : '',
                    'message' => is_string($message['message'] ?? null) ? $message['message'] : '',
                ];
            }

            usort(
                $messages,
                static fn (array $first, array $second): int =>
                    (strtotime($second['timestamp']) ?: 0) <=> (strtotime($first['timestamp']) ?: 0)
            );
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Private inbox</p>
        <h1>Contact submissions</h1>
        <p>Review enquiries sent through the Folacrown Fashion House contact form.</p>
    </div>
</section>

<section class="section">
    <div class="container messages-container">
        <?php if (!$isAuthenticated): ?>
            <div class="login-panel">
                <h2>Sign in to view messages</h2>
                <p>This page is for local administration. Enter the password configured in <code>includes\config.php</code>.</p>
                <?php if ($loginError !== ''): ?>
                    <p class="form-alert form-alert-error" role="alert"><?= e($loginError) ?></p>
                <?php endif; ?>
                <form action="messages.php" method="post" class="contact-form">
                    <div class="form-field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required>
                    </div>
                    <button class="button" type="submit">View messages</button>
                </form>
            </div>
        <?php else: ?>
            <div class="messages-heading">
                <h2>Inbox</h2>
                <span class="count-badge"><?= e((string) count($messages)) ?> <?= count($messages) === 1 ? 'message' : 'messages' ?></span>
            </div>

            <?php if ($storageError !== ''): ?>
                <p class="form-alert form-alert-error" role="alert"><?= e($storageError) ?></p>
            <?php elseif ($messages === []): ?>
                <p class="empty-state">There are no contact submissions yet.</p>
            <?php else: ?>
                <div class="messages-table-wrap">
                    <table class="messages-table">
                        <thead>
                            <tr>
                                <th scope="col">Received</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Service</th>
                                <th scope="col">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?= e($message['timestamp']) ?></td>
                                    <td><?= e($message['name']) ?></td>
                                    <td><a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a></td>
                                    <td><?= e($message['phone'] !== '' ? $message['phone'] : '—') ?></td>
                                    <td><?= e($message['service_title']) ?></td>
                                    <td class="message-cell"><?= e($message['message']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
