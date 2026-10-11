<?php
declare(strict_types=1);

require __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function respond(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, ['message' => 'Method not allowed.']);
}

$expectedToken = $_SESSION['csrf_token'] ?? '';
$submittedToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

if (
    !is_string($expectedToken) ||
    $expectedToken === '' ||
    !is_string($submittedToken) ||
    !hash_equals($expectedToken, $submittedToken)
) {
    respond(403, ['message' => 'Request could not be verified.']);
}

$contentType = strtolower(trim(explode(';', $_SERVER['CONTENT_TYPE'] ?? '', 2)[0]));
if ($contentType !== 'application/json') {
    respond(415, ['message' => 'Expected JSON data.']);
}

$requestBody = file_get_contents('php://input');
if ($requestBody === false || strlen($requestBody) > 10000) {
    respond(400, ['message' => 'Invalid request data.']);
}

try {
    $input = json_decode($requestBody, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $exception) {
    respond(400, ['message' => 'Invalid request data.']);
}

if (!is_array($input)) {
    respond(400, ['message' => 'Invalid request data.']);
}

$email = $input['email'] ?? null;
$message = $input['message'] ?? null;

if (!is_string($email) || !is_string($message)) {
    respond(400, ['message' => 'Enter an email address and message.']);
}

$email = trim($email);
$message = trim($message);

if (
    strlen($email) > 254 ||
    filter_var($email, FILTER_VALIDATE_EMAIL) === false ||
    $message === '' ||
    strlen($message) > 2000
) {
    respond(400, ['message' => 'Check the email and message fields.']);
}

try {
    $database = assignment14Database();

    $statement = $database->prepare(
        'INSERT INTO contact_messages (email, message)
         VALUES (:email, :message)'
    );

    $statement->execute([
        ':email' => $email,
        ':message' => $message,
    ]);

    respond(201, ['message' => 'Your message was sent.']);
} catch (Throwable $exception) {
    // Keep database details out of the response shown to visitors.
    error_log('Assignment 14 contact form database operation failed.');
    respond(500, ['message' => 'The message could not be saved.']);
}
