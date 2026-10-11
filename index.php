<?php
declare(strict_types=1);

require __DIR__ . '/config.php';

$csrfToken = htmlspecialchars(
    (string) $_SESSION['csrf_token'],
    ENT_QUOTES | ENT_SUBSTITUTE,
    'UTF-8'
);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assignment 14 | Secure Contact Form</title>
    <script src="app.js" defer></script>
</head>
<body>
    <main>
        <h1>Assignment 14: Secure Contact Form</h1>
        <p>This example sends form data to PHP for validation and database storage.</p>

        <form id="contact-form">
            <input type="hidden" id="csrf-token" value="<?= $csrfToken ?>">

            <p>
                <label for="email">Email address</label><br>
                <input
                    id="email"
                    name="email"
                    type="email"
                    maxlength="254"
                    autocomplete="email"
                    required
                >
            </p>

            <p>
                <label for="message">Message</label><br>
                <textarea
                    id="message"
                    name="message"
                    maxlength="2000"
                    rows="6"
                    required
                ></textarea>
            </p>

            <button type="submit">Send message</button>
        </form>

        <p id="status" role="status" aria-live="polite"></p>
    </main>
</body>
</html>
