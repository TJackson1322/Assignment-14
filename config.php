<?php
declare(strict_types=1);

// HTTPS is required in production. The conditional keeps the example usable
// with PHP's local development server over HTTP.
$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== '' && $_SERVER['HTTPS'] !== 'off';

ini_set('session.use_strict_mode', '1');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Strict',
]);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function assignment14Database(): PDO
{
    static $connection = null;

    if ($connection instanceof PDO) {
        return $connection;
    }

    $dsn = getenv('DB_DSN');
    $username = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');

    if ($dsn === false || $username === false || $password === false) {
        throw new RuntimeException('Database environment variables are not configured.');
    }

    $connection = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $connection;
}
